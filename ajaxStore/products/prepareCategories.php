<?php
function mapTree($rows, $id_parent = 0, $depth=0){
    $tree = array();
    $last = 0;
    foreach($rows AS $n => $row){
        if($row['id_parent'] == $id_parent){
            $row['depth'] = $depth;
            $row['depth_html'] = str_repeat('|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $depth);
            $row['children'] = array();
            $row['parents'] = array();
            
            $tree[] = $row;
            $tree = array_merge($tree, mapTree($rows, $row['id'], $depth+1 ));
        }
    }
    return $tree;
}



$dbh = new PDO('sqlite:'.DB_DIR.'products');
//$tree = $dbh->query("SELECT c.id, c.id_parent FROM categories c  ORDER BY c.pos")->fetchAll(PDO::FETCH_ASSOC);

$tree = $dbh->query("
SELECT c.id, CASE WHEN cc.id IS NULL THEN 0 ELSE cc.id END AS id_parent 
FROM categories c 
LEFT JOIN categories cc ON (cc.id = c.id_parent) 
ORDER BY c.pos
")->fetchAll(PDO::FETCH_ASSOC);

$tree = mapTree( $tree );

foreach($tree AS $n => $row){
    $begin = false;
    foreach($tree AS $nn => $row1){
        if($row['id'] == $row1['id'])
            $begin = true;
        elseif($row1['depth'] <= $row['depth'] )
            $begin = false;
            
        if($begin)
            $tree[$n]['children'][] = $row1['id'];
    }
}

foreach($tree AS $n => $row){
    $dbh->query("UPDATE categories SET " 
                    ."id_parent = ".$row['id_parent'].", "
                    ."depth = ".($row['depth'] + 1).", "
                    ."children = '".implode(',',$row['children'])."', "
                    ."depth_html = '".$row['depth_html']."', "
                    ."parents = '".implode(',',$row['parents'])."', "
                    ."list_order = ".$n." "
                ."WHERE id = ".$row['id']);
}



///// parents 
$all = $dbh->query("SELECT id FROM categories")->fetchAll(PDO::FETCH_COLUMN);
foreach($all AS $id){
    $parents = array();
    $names = array();
    
    $id_search = $id;
    
    do{
        $id_parent = (int)$dbh->query("SELECT id_parent FROM categories WHERE id = ".$id_search)->fetch(PDO::FETCH_COLUMN);
        $name = $dbh->query("SELECT name FROM categories WHERE id = ".$id_parent)->fetch(PDO::FETCH_COLUMN);
        
        $parents[]= $id_parent;
        $names[] = str_replace(' ','-',$name);
        
        $id_search = $id_parent; 
    }while( $id_parent );


    $current_name = $dbh->query("SELECT name FROM categories WHERE id = ".$id)->fetch(PDO::FETCH_COLUMN);
    $url_rewrite = implode("/",array_reverse($names)).'/'.$id.'-'.$current_name.'/';
    if(!$parents) $parents = array('/');
    $dbh->query("UPDATE categories SET parents = '".implode(',', array_reverse($parents))."', url_rewrite = '".str_replace(array(' '),'-',$url_rewrite)."' WHERE id = $id");
}



