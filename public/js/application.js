// FORM SUBMIT

$("form").on("submit",function(e){ 
    e.preventDefault();
    var $form = $(this);
    $(".uk-form-danger", $form).removeClass('uk-form-danger');
    
    $.post($(this).attr('action'), $(this).serialize()).done(function(ret){
        $("body").find(".uk-alert").remove();
        ret = $.parseJSON(ret);
        if(ret.required){
            $.each(ret.required, function(i,field){ $("[name='"+field+"']", $form).addClass("uk-form-danger"); });
            $form.prepend('<div class="uk-alert uk-alert-danger"><b>Fill down Required fields</b></div>');
        }else if(ret.error){
            $form.prepend('<div class="uk-alert uk-alert-danger"><b>'+ret.error+'</b></div>');
        }else if(ret.success){
            window.location.href = "profile.php";
        }
    });
});


// dataTables

$("table.dataTable").each(function(k,t){
    var p = {'columnDefs':[]};
    $.each( $(t).data(), function(a,v){ p[a] = v; });
    $(t).find("thead > tr > *").each(function(l,h){ 
        p['columnDefs'][l] = {'targets': l};
        $.each( $(h).data(), function(a,v){ 
            if(a == "render") p['columnDefs'][l]['render'] = function(d,t,r){ return eval(v); };
            else p['columnDefs'][l][a] = v;
        });
    });
    $(t).dataTable(p);
});

//

