
// TABLE triggers

$("[data-trigger-reload]").each(function(k,t){
    $.each( $(this).data("trigger-reload").split(","), function(kk,tr){
        $(document).on($.trim(tr), function(e){
            $(t).css("opacity",0);
            $(t).DataTable().ajax.reload();
            $(t).animate({opacity:1},"slow");
        });
    });
});
$("[data-trigger-update]").each(function(k,t){
    $.each(  $(this).data("trigger-update").split(","), function(kk,tr){
        $(document).on( tr, function(e, d){
            if(d.id || (d.data && d.data[0] && d.data[0][0])){
                //var row = $(t).find("[data-id="+(d.id?d.id:d.data[0][0])+"]").closest("tr");
                var row = $(t).find(".id:contains("+d.id+")").closest("tr");
                $(row).css("opacity",0);
                $(t).dataTable().api().row( row ).data(d.data[0]).draw(false);
                $(row).animate({opacity:1},"slow");
            }
        });
    });
});
$("[data-trigger-delete]").each(function(k,t){
    $.each($(this).data("trigger-delete").split(","), function(kk,tr){
        $(document).on(tr, function(e, d){
            var row = $(t).find(".id:contains("+d.id+")").closest("tr");
            $(row).animate({opacity:0},"slow",function(){ $(t).dataTable().api().row(row).remove().draw(false);  });
        });
    });
});
$("[data-trigger-add]").each(function(k,t){
    $.each($(this).data("trigger-add").split(","), function(kk,tr){
        $(document).on( tr,function(e, d){
            $.when( $(t).dataTable().api().row.add(d.data[0]).draw(false) ).done(function(){
                $(t).find(".id:contains("+d.id+")").closest("tr").css("opacity",0).animate({opacity:1},"slow");
            });
        });
    });
});


// dataTables

$("table.dataTable").each(function(k,t){
    if ( $.fn.DataTable.isDataTable(t) ) return;
    
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


// TOGGLE

$(document).on("click","a[data-toggle]",function(e){
    e.preventDefault();
    var data_post = $(this).data("post"), // {"id":"","field":"is_active"}
        field = $(this).data("toggle"),
        url = $(this).attr("href"),
        trigs = $(this).data("trigger");
    var d = {};
    if(typeof data_post=="object") $.each( data_post,function(k,v){
        d[k]=v;
    });
    if(field) d['field'] = field;
    $.post(url,d).done(function(ret){
        ret = $.parseJSON(ret);
        if(ret.error){
            UIkit.notify(ret.error,"danger");
        }else if(ret.success){
            if(typeof trigs !== 'undefined') $.each( trigs.split(","), function(k,trig){    
                $(document).trigger($.trim(trig), ret);
            })
            UIkit.notify(ret.success,"success");
        }
    });
});



// FORM

// Form Init

$(document).on("click","a[href][data-uk-modal]", function(e){
    var data_get=$(this).data("get"),
        populate=$(this).data("populate"),
        id_parent = $(this).closest(".uk-modal").find("input[name=id]").val(),
        modal = $($(this).attr("href")),
        url_get = modal.data("get"),
        form = modal.find("form")[0];
        
    if(typeof form !== 'undefined') form.reset();
    modal.find("select").find("[selected]").prop("selected",false);
    modal.find("select.select2[data-ajax--url]").html("");
    modal.find("select").trigger("change");

    if ( $.isFunction(UIkit.htmleditor) )  $('.CodeMirror')[0].CodeMirror.setValue("");
    modal.find(".uk-form-danger").removeClass('uk-form-danger');
    modal.find(".uk-alert").remove();
    if(typeof populate == "object") $.each(populate,function(k,v){
        modal.find("[name='"+k+"']").each(function(){ if($(this).prop("tagName")=="INPUT") $(this).val(v); else $(this).text(v); });
    });
    if(typeof id_parent !== 'undefined') modal.find("[name=id_parent]").each(function(){
        if($(this).prop("tagName") == "INPUT") $(this).val(id_parent)
        else $(this).html(id_parent);
    });
    modal.find("table[data-get]").each(function(){
        var table_get = $(this).data("get");
        if(typeof data_get == "string") table_get += (table_get.indexOf("?") > -1 ? "&" :"?") + data_get;
        $(this).DataTable().ajax.url( table_get ).load();
    });
    if(typeof url_get !== 'undefined'){
        $.getJSON(url_get+(url_get.indexOf("?")>-1?"&":"?")+data_get).done(function(ret){
            if(ret.data && ret.data[0]) $.each(ret.data[0], function(k,v){
                modal.find("[name='"+k+"']").each(function(r,input){ input = $(this);
                    if(input.prop("tagName") == "SELECT"){
                        if(v)$.each(v.split(","),function(kk,vv){ 
                                var opt = $(input).find("option[value='"+vv+"']");
                                if(typeof $(opt).prop("tagName") == "undefined"){$(input).append('<option value="'+vv+'">'+vv+'</option>');}
                                $("option[value='"+vv+"']",input).prop("selected",true); 
                            });
                            input.trigger("change");
                    }else if(input.prop("tagName") == "INPUT"){
                        if(input.attr("type") == "checkbox") input.prop("checked",v);
                        else input.val(v);
                        input.trigger("change");
                    }else if( input.prop("tagName") == "TEXTAREA" ){
                        if(typeof input.attr("data-uk-htmleditor") !== "undefined"){
                            var editor = $('.CodeMirror')[0].CodeMirror;
                            editor.setValue(v);
                            editor.setOption("mode",$(input).data("mode")||"text/html");
                        }else{
                            input.html(v);
                            input.trigger("change");
                        }
                    }else {
                        if( input.hasClass("uk-switcher")) {  
                            input.children("[data-value]").removeClass("uk-active");
                            input.children("[data-value="+v+"]").addClass("uk-active");
                        }else{
                            input.html(v);
                        }
                    }
                });
            });
            modal.trigger("populated",ret);
        });
    }else UIkit.modal(modal).show();
});

// Form Submit

$("select[type=submit]").on("change",function(e){if($(this).val()!='' && $(this).val()!=0 && $(this).val()!==null) $(this).closest("form").submit()});

$("form").submit(function(e){ 
    e.preventDefault();
    var $form = $(this);
    
    $form.find(".uk-switcher>*").each(function(){$(this).find("[type=hidden]").prop("disabled",!$(this).hasClass("uk-active"))});
    $form.find(".uk-form-danger").removeClass('uk-form-danger');
    $form.find(".uk-alert").remove();

    var uploadprogress_oldtext = $(".upload-progress").html();    
    
    $.ajax({
        url: $form.attr('action'),
        data: new FormData( $form[0] ),
        type: 'post',
        dataType: "json",
        processData: false,
        contentType: false,
        xhr: function(){
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt){ if (evt.lengthComputable) {
                $(".upload-progress").html(parseInt( (evt.loaded / evt.total)*100, 10) + "%");
            } }, false);
            return xhr;
        },
    }).always(function() {
        $(".upload-progress").html(uploadprogress_oldtext);
    }).done(function(ret){
        if(ret.required){
            $.each(ret.required, function(i,field){ 
                var input = $("[name='"+field+"']", $form);
                input.addClass("uk-form-danger"); 
                if(input.hasClass("select2-hidden-accessible")){ input.next().find(".select2-selection").addClass("uk-form-danger") }
            });
            $form.prepend('<div class="uk-alert uk-alert-danger"><b>Fill down Required fields</b></div>').scrollTop();
        }
        if(ret.success){
            var modal = $form.closest(".uk-modal");
            if(typeof modal.data("hide-on-submit") !== 'undefined') UIkit.modal(modal).hide();
            if(typeof($form.data("trigger")) !== "undefined") $.each( $form.data("trigger").split(","), function(k,trig){
                $(document).trigger($.trim(trig), ret);
            });
            UIkit.notify(ret.success, "success");
        }
        if(ret.error) UIkit.notify(ret.error, "danger");
    });
});



// SELECT2

$("select.select2").each(function(k,o){
    var sets = {};

    if(typeof $(this).data("ajax--url") == "string") {
        sets["ajax"] = {};
        sets["ajax"]["cache"] = $(this).data("ajax--cache")||true;
        sets["ajax"]["delay"] = $(this).data("ajax--delay")||550;
        sets["ajax"]["dataType"] = $(this).data("ajax--dataType")||"json";
        sets["ajax"]["processResults"]=function(d,p){p.page=p.page||1;return{results:d.data||d.results,pagination:{more:(p.page*30)<d.total_count}};};
    }
    if(typeof $(this).data("tags") == "boolean" ) sets["tags"] = true;
    if(typeof $(this).attr("data-tokenSeparators")  !== "undefined") sets['tokenSeparators'] = $(this).attr("data-tokenSeparators");
    
    var ph = $(this).attr("data-placeholder"); 
    if(typeof ph =="undefined") {
        $(this).attr("data-placeholder",""); // because a bug with templates
        ph = "";
    }else{
        ph='<span class="uk-text-muted">'+ph+'</span>';
    }
    
    var tSel = $(this).attr("data-templateSelection");
    if( typeof tSel != "undefined") sets['templateSelection'] = function(s){ if(!s.id || s.id=="undefined") return (s.text!="undefined"?s.text:$(ph)); 
        if( $(s.element).attr("data-json") ) s = $.parseJSON( $(s.element).attr("data-json") );
        var template = tSel; $.each(s, function(k,v){ template = template.replace(new RegExp("{{"+k+"}}","g"),v); });
        return $( '<span>'+template+'</span>' )
    };
    
    var tRes = $(this).attr("data-templateResult");
    if( typeof tRes != "undefined") sets['templateResult'] = function(s){ if(!s.id||s.id=="undefined") return (s.text!="undefined"?s.text:$(ph)); 
        if( $(s.element).attr("data-json") ) s = $.parseJSON( $(s.element).attr("data-json") );
        var template = tRes; $.each(s, function(k,v){ template = template.replace(new RegExp("{{"+k+"}}","g"),v)});
        return $( '<span>'+template+'</span>' );
    };
    
    $(this).select2(sets);
});


// INIT Data  +  DEPENDANCES

$("select[data-get], input[data-get], textarea[data-get]").each(function(){ if(typeof $(this).data("depends-on") ==="undefined" ) _dataGet(this, $(this).data("get") ); });


$("select[data-value-depends-on]").each(function(n,obj){
    var dep = $(obj).data("value-depends-on")||''; dep = dep.split(",");
    $($.trim(dep[0])).on("change",function(){ 
        var d = $.parseJSON( $(dep[0]).attr("data-json") );
        $(obj).find("[selected]").prop("selected",false);
        $(obj).find("option[value="+d[$(obj).prop("name")]+"]").prop("selected",true);    
    }); 
});

$("select[data-depends-on], input[data-depends-on], textarea[data-depends-on]").each(function(n,obj){ 
    var dep = $(obj).data("depends-on")||''; dep = dep.split(",");
    $($.trim(dep[0])).on("change",function(){ _dataGet(obj,$(obj).data("get")); }); 
});

function _dataGet(obj,url){
    //var url = $(obj).data("get");
    var dep = $(obj).data("depends-on")||''; 
    if(typeof url == "string"){
        $.each(dep.split(","), function(k,id){ id=$.trim(id); url += "&"+$(id).attr("name")+"="+$(id).val() });
        $.getJSON( url ).done(function(ret){ _fillTag(ret); });
    }else _fillTag( {data:$.parseJSON( $(dep).attr("data-json") )} );
    
    function _fillTag(ret){
        if(ret.data===false) ret.data="";
        switch ( $(obj).prop("tagName") ) {
            case "TEXTAREA": 
            case "INPUT": 
                if(typeof ret.data == "object"){
                    if(typeof ret.data[0] == "object") ret['data']=ret['data'][0];
                    $(obj).attr("data-json",JSON.stringify(ret.data));
                    var d=ret.data[ $(obj).attr("name") ];
                    if(typeof d == "undefined") d = ret.data.text||ret.data.name;
                    if( $(obj).prop("tagName") == "TEXTAREA")  $(obj).html(d);
                    else $(obj).val(d);
                }else{ $(obj).val(ret.data); }
                break;
            case "SELECT":  
                $(obj).html("");
                $.each(ret.data, function(k,v){ 
                    $(obj).append('<option data-json=\''+JSON.stringify(v)+'\' value="'+v.id+'">'+(v.text||v.name)+'</option>'); 
                }); break;
        }
        $(obj).trigger("change");
    }
}


// SPARKLINE
$(".page-sparkline").each(function(k,v){
    m = $(this).data('table');
    $.getJSON("ajax.php?f=sparkline&m="+ m).done(function(ret){
        var sets = {   type: 'line', 
                defaultPixelsPerValue:10,
                tooltipSuffix:m,
                tooltipFormat: '{{x:levels}} {{prefix}} - {{y}} {{suffix}}',
                tooltipValueLookups: {levels: $.range_map({ ':1': 'January', '1:2': 'Februry', '2:3': 'March','3:4':'April','4:5':'May','5:6':'Jun','6:7':'Jul','7:8':'August','8:9':'September','10':'Octomber','11':'November','12':'December' }) }
            };
        $(v).sparkline(ret.data, $.extend(sets,ret.sets) );
    });
});