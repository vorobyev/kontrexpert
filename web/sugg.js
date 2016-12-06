    $("#sugg1").suggestions({
        serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
        token: "bf92e68f3b6e3424159c09e7ee02de8996fd42df",
        type: "PARTY",
        count: 5,
        deferRequestBy:700,
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
            inn = suggestion.data.inn;
            if (inn.length == 10){
		$('#organization-address').css('display','inline');
		$('label[for="organization-address"]').css('display','inline-block');
		
		$('#organization-kpp').css('display','inline');
		$('label[for="organization-kpp"]').css('display','inline-block');
		
		$('#organization-rukovod').attr('readonly',true);
		//$('label[for="organization-rukovod"]').attr('readonly',true);
		
		$('#organization-rukovod2').css('display','inline');
		$('label[for="organization-rukovod2"]').css('display','inline-block');
                
                $('#organization-addressreg').css('display','none');
		$('label[for="organization-addressreg"]').css('display','none');
		
		$('#red_ruk').css('display','inline');
		$('input[name="myCheck"]').css('display','inline-block');
		
		getORG(suggestion);
	} else {
		$('#organization-address').css('display','none');
		$('label[for="organization-address"]').css('display','none');
		
		$('#organization-kpp').css('display','none');
		$('label[for="organization-kpp"]').css('display','none');
		
		$('#organization-rukovod').attr('readonly',false);
		//$('label[for="organization-rukovod"]').css('readonly',false);
		
		$('#organization-rukovod2').css('display','none');
		$('label[for="organization-rukovod2"]').css('display','none');
		
                $('#organization-addressreg').css('display','inline');
		$('label[for="organization-addressreg"]').css('display','inline-block');
                
		$('#red_ruk').css('display','none');
		$('input[name="myCheck"]').css('display','none');
		getIP(suggestion);
	}
        
        
        }
    });

function getIP(suggestion) {
    $('#organization-inn').val(suggestion.data.inn);
    $('#organization-fullname').val("ИП "+suggestion.data.name.full);
    $('#organization-name').val("ИП "+suggestion.data.name.full.split(' ')[0]+" "+suggestion.data.name.full.split(' ')[1].charAt(0)+"."+suggestion.data.name.full.split(' ')[2].charAt(0)+".");
    $('#organization-rukovod').val(suggestion.data.name.full_with_opf);
    $('#organization-name1c').val(suggestion.data.name.full.split(' ')[0]+" "+suggestion.data.name.full.split(' ')[1].charAt(0)+"."+suggestion.data.name.full.split(' ')[2].charAt(0)+"."+" ИП");

    $("label[for='organization-name1c']").html("Наименование для 1С ("+$("#organization-name1c").val().length+"/30 символов)");
    $('#organization-ogrn').val(suggestion.data.ogrn);
    $('#organization-address').val("");
    $('#organization-addressreg').val(suggestion.data.address.value);
    $('#organization-addressfact').val(suggestion.data.address.value);
    $('#organization-okpo').val("");
    $('#organization-kpp').val("");
    
}

function getORG(suggestion){
    $('#organization-inn').val(suggestion.data.inn);
    $('#organization-fullname').val(suggestion.data.name.full_with_opf);
    $('#organization-name').val(suggestion.data.name.short_with_opf);
	mas = suggestion.data.name.short_with_opf.replace('\'','').replace('"','').replace('`','').replace('"','').split(' ');
	str = "";
	mas.forEach(function(item, i, arr) {
		if (i!=0){
			if (i!=1){
				str = str+" "+item;
			} else {
				str = str+item;
			}
		}
	});
	str = str+" "+mas[0];
	$('#organization-name1c').val(str);
	
	$("label[for='organization-name1c']").html("Наименование для 1С ("+$("#organization-name1c").val().length+"/30 символов)");
    $('#organization-kpp').val(suggestion.data.kpp);
    $('#organization-ogrn').val(suggestion.data.ogrn);
    $('#organization-address').val(suggestion.data.address.value);
    $('#organization-addressreg').val("");
    $('#organization-rukovod').val("");
    $('#organization-addressfact').val(suggestion.data.address.value);
    if (suggestion.data.management instanceof Array) {
            suggestion.data.management.forEach(function(item, i, arr){
                var x = document.getElementById("organization-rukovod2");
                var option = document.createElement("option");
                option.value = i;
                x.add(option); 
                $('#organization-rukovod').val(suggestion.data.management[i].post+' '+suggestion.data.management[i].name);
                $('#organization-rukovod2 option[value="'+String(i)+'"]').html(suggestion.data.management[i].post+' '+suggestion.data.management[i].name);
        });
    } else {
        var x = document.getElementById("organization-rukovod2");
        var option = document.createElement("option");
        option.value = 0;
        x.add(option); 
        $('#organization-rukovod').val(suggestion.data.management.post+' '+suggestion.data.management.name);
        $('#organization-rukovod2 option[value="0"]').html(suggestion.data.management.post+' '+suggestion.data.management.name);
    }
}