<?php
header("Cache-Control: max-age=43200"); //1/2days (60sec * 60min * 12hours * 1days)
header("Expires:".date("D, M j G:i:s",(time()+86400)) );
header("pragma:cache");

$ret=array('data'=>array(null));
$get=filter_var_array($_GET,array(
    'm'=>FILTER_SANITIZE_STRING    
));
$year = date("Y");
$charts = array(
    'customers_orders'=>array(
        'db'=>'customers',
        'sql'=>"SELECT COUNT(id) num, strftime('%m',date(date_add,'unixepoch')) mo FROM orders WHERE date_add > ".strtotime("1/1/$year")." AND date_add < ".strtotime("12/31/$year")." GROUP BY mo ORDER BY date_add",
        'sets'=>array( 'tooltipSuffix'=>'new orders'),
    ),
    'customers'=>array(
        'db'=>'customers',
        'sql'=>"SELECT COUNT(id) num, strftime('%m',date(date_add,'unixepoch')) mo FROM customers WHERE date_add > ".strtotime("1/1/$year")." AND date_add < ".strtotime("12/31/$year")." GROUP BY mo ORDER BY date_add",
        'sets'=>array( 'tooltipSuffix'=>'new registered customers'),
    ),
    'products'=>array(
        'db'=>'products',
        'sql'=>"SELECT COUNT(id) num, strftime('%m',date(date_add,'unixepoch')) mo FROM products WHERE date_add > ".strtotime("1/1/$year")." AND date_add < ".strtotime("12/31/$year")." GROUP BY mo ORDER BY date_add",
        'sets'=>array( 'tooltipSuffix'=>'new products'),
    ),
    'suppliers'=>array(
        'db'=>'suppliers',
        'sql'=>"SELECT COUNT(id) num, strftime('%m',date(date_add,'unixepoch')) mo FROM suppliers WHERE date_add > ".strtotime("1/1/$year")." AND date_add < ".strtotime("12/31/$year")." GROUP BY mo ORDER BY date_add",
        'sets'=>array( 'tooltipSuffix'=>'new registered suppliers'),
    ),
    'blogs'=>array(
        'db'=>'blogs',
        'sql'=>"SELECT COUNT(id) num, strftime('%m',date(date,'unixepoch')) mo FROM blogs WHERE date > ".strtotime("1/1/$year")." AND date < ".strtotime("12/31/$year")." GROUP BY mo ORDER BY date",
        'sets'=>array( 'tooltipSuffix'=>'new articles'),
    ),
);


if(isset($charts[$get['m']])){
    $ret['sets'] = array_merge( array(
        'tooltipPrefix'=>" / ".$year,
        'chartRangeMin'=>0,
        'tooltipFormat'=>'{{x:levels}} {{prefix}} - {{y}} {{suffix}}',
        //'tooltipValueLookups'=>array('levels'=>),//"{levels: $.range_map({ ':1': 'January', '1:2': 'Februry', '2:3': 'March','3:4':'April','4:5':'May','5:6':'Jun','6:7':'Jul','7:8':'August','8:9':'September','10':'Octomber','11':'November','12':'December' }) }",
    ),$charts[$get['m']]['sets']);

    $dbh = new PDO('sqlite:'.DB_DIR.$charts[$get['m']]['db']);
    $d = $dbh->query($charts[$get['m']]['sql'])->fetchAll(PDO::FETCH_ASSOC);
    
    $ret['data'] = array(null,null,null,null,null,null,null,null,null,null,null,null);
    $c_m = date('m');
    for($i=0;$i<13;$i++){
        if($i < $c_m) $ret['data'][$i] = 0;
        else $ret['data'][$i] = null;
    }
    
    foreach($d AS $k=>$v){
        $ret['data'][(int)$v['mo']] = $v['num'];
    }
}
return json_encode($ret);