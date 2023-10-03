function graphique_suivant_lindicateur(indicateur,select_concerne){
    var url = "{{ route('impact.donnees_par_secteurdactivite') }}"
    var url2 = "{{ route('impact.donnees_par_zone') }}"
    var categorie= $('#'+select_concerne).val();
 
    $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                 data: {categorie:categorie, indicateur:indicateur},
                 error:function(data){if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }},
                 success: function (data) {
                    var table_line = '';
                    var donnee= data[0];
                    var donnee1= data[1];
                    var temp0= 0;  
                    var temp1= 0;
                    for (var x = 0; x < donnee.length; x++) {
                        console.log(donnee[x]);
                         var y=  donnee[x].secteur_dactivite; 
                         var nombre=parseInt(donnee[x].nombre);
                         table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                         }
                   $('.tbadys_secteur').html(table_line); 
                        var donnch= new Array();
                        var donnch1= new Array();
                        var secteurdactivites = new Array();
                        for(var i=0; i<donnee.length; i++)
                            {
                                    donnch.push({
                                        y:  parseInt(donnee[i].nombre)
                                    });
                            }
                            for(var i=0; i<donnee1.length; i++)
                            {
                                    donnch1.push({
                                        y:  parseInt(donnee1[i].nombre)
                                    });
                            }
                   
                    for(var i=0; i<donnee.length; i++)
                        {
                            secteurdactivites[i] = donnee[i].secteur_dactivite
                        }
                    console.log(secteurdactivites);
                    var areaChartData = {
                                labels  : secteurdactivites,
                                datasets: [
                                    {
                                    label               : 'ayant evolué',
                                    backgroundColor     : 'rgba(60,141,188,0.9)',
                                    borderColor         : 'rgba(60,141,188,0.8)',
                                    pointRadius          : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : donnch
                                    },
                                    {
                                    label               : "n'ayant pas evolué",
                                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                                    borderColor         : 'rgba(210, 214, 222, 1)',
                                    pointRadius         : false,
                                    pointColor          : 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor    : '#c1c7d1',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data                : donnch1
                                    },
                                ]
                                }
                                var areaChartOptions = {
                                        maintainAspectRatio : false,
                                        responsive : true,
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            xAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }],
                                            yAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }]
                                        }
                                        }
                   var barChartCanvas = $('#graph_secteur_dactivite').get(0).getContext('2d')
                        var barChartData = $.extend(true, {}, areaChartData)
                         temp0 = areaChartData.datasets[0]
                         temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0
                        var barChartOptions = {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false
                        }
                        new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                        })

}

});
$.ajax({
                 url: url2,
                 type: 'GET',
                 dataType: 'json',
                data: {categorie:categorie, indicateur:indicateur},
                 error:function(data){if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }},
                 success: function (data) {
                    var donnee= data[0];
                    var donnee1= data[1];
                        var table_line = '';
                    for (var x = 0; x < donnee.length; x++) {
                        console.log(donnee[x]);
                         var y=  donnee[x].zone; 
                         var nombre=parseInt(donnee[x].nombre);
                        table_line +='<tr> <td > ' + y + '</td><td > ' + nombre + '</td></tr>';
                         }
                   $('.tbadys_zone').html(table_line); 
                        var donnch= new Array();
                        var donnch1= new Array();
                        var zones = new Array();
                        for(var i=0; i<donnee.length; i++)
                            {
                                donnch.push({
                                    name: donnee[i].zone,
                                    y:  parseInt(donnee[i].nombre)
                                });
                            }
                            for(var i=0; i<donnee1.length; i++)
                            {
                                    donnch1.push({
                                        y:  parseInt(donnee1[i].nombre)
                                    });
                            }
                            console.log('okok')
                            console.log(donnch)
                    for(var i=0; i<donnee.length; i++)
                        {
                            zones[i] = donnee[i].zone
                        }
                    //console.log(zones);
                    var areaChartData = {
                                labels  : zones,
                                datasets: [
                                    {
                                    label               : 'ayant evolué',
                                    backgroundColor     : 'rgba(60,141,188,0.9)',
                                    borderColor         : 'rgba(60,141,188,0.8)',
                                    pointRadius          : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : donnch
                                    },
                                    {
                                    label               : "n'ayant pas evolué",
                                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                                    borderColor         : 'rgba(210, 214, 222, 1)',
                                    pointRadius         : false,
                                    pointColor          : 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor    : '#c1c7d1',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data                : donnch1
                                    },
                                ]
                                }
                                var areaChartOptions = {
                                        maintainAspectRatio : false,
                                        responsive : true,
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            xAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }],
                                            yAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }]
                                        }
                                        }
                   var barChartCanvas = $('#graph_zone').get(0).getContext('2d')
                        var barChartData = $.extend(true, {}, areaChartData)
                        var temp0 = areaChartData.datasets[0]
                        var temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0
                        var barChartOptions = {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false
                        }
                        new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                        })
                    

}

});

} 

function emploi_par_secteurdactivite(){
    var url = "{{ route('impact.emploi_par_secteurdactivite') }}"
    var url2 = "{{ route('impact.emploi_par_zone') }}"
    var categorie= $('#categorie_entreprise_id').val();
    $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                data: {categorie:categorie},
                 error:function(data){if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }},
                 success: function (data) {
                        var emp_permanent= new Array();
                        var emp_temporaire= new Array();
                        var secteurdactivites = new Array();
                        donnee=data[0];
                        donnee1=data[1];
                        for(var i=0; i<donnee.length; i++)
                            {
                                emp_permanent.push({
                                        y:  parseInt(donnee[i].nombre)
                                    });
                            }
                            for(var i=0; i<donnee1.length; i++)
                            {
                                emp_temporaire.push({
                                        y:  parseInt(donnee1[i].nombre)
                                    });
                            }
                    
                    for(var i=0; i<donnee.length; i++)
                        {
                            secteurdactivites[i] = donnee[i].secteur_dactivite
                        }
                   // console.log(secteurdactivites);
                    var areaChartData = {
                                labels  : secteurdactivites,
                                datasets: [
                                    {
                                    label               : 'Emplois permanents',
                                    backgroundColor     : 'rgba(60,141,188,0.9)',
                                    borderColor         : 'rgba(60,141,188,0.8)',
                                    pointRadius          : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : emp_permanent
                                    },
                                    {
                                    label               : 'Emplois temporaires',
                                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                                    borderColor         : 'rgba(210, 214, 222, 1)',
                                    pointRadius         : false,
                                    pointColor          : 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor    : '#c1c7d1',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data                : emp_temporaire
                                    },
                                ]
                                }
                                var areaChartOptions = {
                                        maintainAspectRatio : false,
                                        responsive : true,
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            xAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }],
                                            yAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }]
                                        }
                                        }
                   var barChartCanvas = $('#emploi_secteur_dactivite').get(0).getContext('2d')
                        var barChartData = $.extend(true, {}, areaChartData)
                        var temp0 = areaChartData.datasets[0]
                        var temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0
                        var barChartOptions = {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false
                        }
                        new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                        })
}

});
        $.ajax({
                         url: url2,
                         type: 'GET',
                         dataType: 'json',
                        data: {categorie:categorie},
                         error:function(data){
                        if (xhr.status == 401) {
                            window.location.href = 'https://www.bravewomen.bf/login';
                        }},
                         success: function (data) {
                                var emp_permanent= new Array();
                                var emp_temporaire= new Array();
                                donnee=data[0];
                                donnee1=data[1]
                                var zones = new Array();
                                for(var i=0; i<donnee.length; i++)
                                    {
                                        emp_permanent.push({
                                                y:  parseInt(donnee[i].nombre)
                                            });
                                    }
                            console.log(emp_permanent);
                            for(var i=0; i<donnee1.length; i++)
                                    {
                                        emp_temporaire.push({
                                                y:  parseInt(donnee1[i].nombre)
                                            });
                                    }

                            for(var i=0; i<donnee.length; i++)
                                {
                                    zones[i] = donnee[i].zone
                                }
                            
                           console.log('zones')
                            console.log(zones);
                            var areaChartData = {
                                labels  : zones,
                                datasets: [
                                    {
                                    label               : 'Emplois permanents',
                                    backgroundColor     : 'rgba(60,141,188,0.9)',
                                    borderColor         : 'rgba(60,141,188,0.8)',
                                    pointRadius          : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : emp_permanent
                                    },
                                    {
                                    label               : 'Emplois temporaires',
                                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                                    borderColor         : 'rgba(210, 214, 222, 1)',
                                    pointRadius         : false,
                                    pointColor          : 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor    : '#c1c7d1',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data                : emp_temporaire
                                    },
                                ]
                                }
                                var areaChartOptions = {
                                        maintainAspectRatio : false,
                                        responsive : true,
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            xAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }],
                                            yAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }]
                                        }
                                        }
                   var barChartCanvas = $('#emploi_zone').get(0).getContext('2d')
                        var barChartData = $.extend(true, {}, areaChartData)
                        var temp0 = areaChartData.datasets[0]
                        var temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0
                        var barChartOptions = {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false
                        }
                        new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                        })
                    }
        });
        
} 
function beneficiaire_ayant_declare_augmente_effectif_par_secteurdactivite(){ 
    var url= "{{ route('impact.baneficaire_ayant_cree_emplois') }}"
    var categorie= $('#categorie_entreprise_id').val();
    $.ajax({
                 url: url,
                 type: 'GET',
                 dataType: 'json',
                data: {categorie:categorie},
                 error:function(data){if (xhr.status == 401) {
                    window.location.href = 'https://www.bravewomen.bf/login';
                }},
                 success: function (data) {
                        var benef_ayant_cree= new Array();
                        var benef_nayant_pas_cree= new Array();
                        var secteurdactivites = new Array();
                        donnee=data[0];
                        donnee1=data[1];
                        for(var i=0; i<donnee.length; i++)
                            {
                                benef_ayant_cree.push({
                                        y:  parseInt(donnee[i].nombre)
                                    });
                            }
                            for(var i=0; i<donnee1.length; i++)
                            {
                                benef_nayant_pas_cree.push({
                                        y:  parseInt(donnee1[i].nombre)
                                    });
                            }
                    
                    for(var i=0; i<donnee.length; i++)
                        {
                            secteurdactivites[i] = donnee[i].secteur_dactivite
                        }
                        var areaChartData = {
                                labels  : secteurdactivites,
                                datasets: [
                                    {
                                    label               : 'Personnel ayant evolué',
                                    backgroundColor     : 'rgba(60,141,188,0.9)',
                                    borderColor         : 'rgba(60,141,188,0.8)',
                                    pointRadius          : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : benef_ayant_cree
                                    },
                                    {
                                    label               : 'Personnel stable',
                                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                                    borderColor         : 'rgba(210, 214, 222, 1)',
                                    pointRadius         : false,
                                    pointColor          : 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor    : '#c1c7d1',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data                : benef_nayant_pas_cree
                                    },
                                ]
                                }
                                var areaChartOptions = {
                                        maintainAspectRatio : false,
                                        responsive : true,
                                        legend: {
                                            display: false
                                        },
                                        scales: {
                                            xAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }],
                                            yAxes: [{
                                            gridLines : {
                                                display : false,
                                            }
                                            }]
                                        }
                                        }
                   var barChartCanvas = $('#beneficiaire_ayant_declare_creation_demploi').get(0).getContext('2d')
                        var barChartData = $.extend(true, {}, areaChartData)
                        var temp0 = areaChartData.datasets[0]
                        var temp1 = areaChartData.datasets[1]
                        barChartData.datasets[0] = temp1
                        barChartData.datasets[1] = temp0
                        var barChartOptions = {
                        responsive              : true,
                        maintainAspectRatio     : false,
                        datasetFill             : false
                        }
                        new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                        })
}

});

        
}