






















// /*=================================================================
// =            FUNCION PARA HACER BUSQUEDA EN UN ARREGLO            =
// =================================================================*/
// function Busqueda_Arreglo(base,text){
//   return base.filter(function(el){
//     return el.toLowerCase().indexOf(text.toLowerCase()) > -1;
//   })
// }

// /*=====================================================
// =            SECCION PARA MOSTRAR GRAFICOS            =
// =====================================================*/
// anychart.onDocumentReady(function () {
//   /*===================================================
//   =            EQUIPOS POR CIUDAD CONSULTA            =
//   ===================================================*/
//   var totalEq = [];
//   var datos = new FormData();
//   datos.append("Eqxciudad","equixciudad");
//   $.ajax({
//       url: "ajax/equipos.ajax.php",
//       method: "POST",
//       data: datos,
//       cache: false,
//       contentType: false,
//       processData: false,
//       dataType: "json",
//       success: function(respuesta) {
//         //debugger;
//         var resulta;
//         if (respuesta != ""){
//           for (var i = 0; i < respuesta.length; i++) {
//             resulta = respuesta[i]["codigo"].includes("MC");
//             if (resulta && respuesta[i]["estado"] !=  0){
//               totalEq.push(respuesta[i]["idciudad"]);

//             }
            
//           }
//         }
//         /*=======================================================
//         =            BUSQUEDA EN EL ARREGLO FUNCTION            =
//         =======================================================*/
//           // JSON data
//           var chart = anychart.fromJson({
//             "chart": {
//               "type": "column",
//               "series":[{
//                 // first series data
//                 "data": [
//                   {"x": "GUAYAQUIL", "value": Busqueda_Arreglo(totalEq,'1').length},
//                   {"x": "QUITO", "value": Busqueda_Arreglo(totalEq,'2').length}
//                 ],
//                 "fill":"#00cc00",
//                 "stroke": "0"
//               }],
//               "container": "container",
//             "yScale": {       // invoke y scale
//                 "minimum": 0, // set minimum value
//                 "maximum": 50  // set maximum value
//               },
//             "title": {
//                 // set title text
//                 "text": "Equipos por Ciudad",
//                 // title background settings
//               }              
//             }            
//           });
//           /*=====  PADDIND DE TOOLTIP   ======*/
          
//           chart.tooltip().padding().left(20);
//           /*=====  ELIMINAR EL MENU CONTEXTUAL  ======*/
//           chart.contextMenu(false);
//           /*=====  SERIE  ======*/
//           var tooltip = chart.getSeries(0).tooltip();
//           tooltip.format("Total: {%value}");          
//           chart.draw();
//           $("#container").css("height","200px");

//           $(".anychart-credits").hide();
//       }
//   })
// /*=======================================================
// =            GRÁFICO #2 NOVEDADES REPORTADAS            =
// =======================================================*/

// });
// var chart;
// anychart.onDocumentReady(function() {
//     chart = anychart.column();
//     chart.data({
//         header: ['#', 'Oil', 'Gas', 'Gasoline', 'Diesel fuel'],
//         rows: [
//             ['2013', 21, 99, 19, 72],
//             ['2014', 41, 7, 71, 10],
//             ['2015', 9, 15, 77, 58],
//             ['2016', 71, 34, 40, 21],
//             ['2017', 6, 29, 11, 46]
//         ]
//     });

//     // Distribute series by series names or point names
//     // true: by series names
//     // false: by point names
//     chart.categorizedBySeries(true);

//     chart.legend().enabled(true).position('bottom');
//     chart.container('container2');
//     chart.draw();
// });

// /*===============================================================================
// =            CAMBIAR EL GRAFICO POR CIUDAD GUAYAQUIL QUITO NOVEDADES            =
// ===============================================================================*/
// $ ("#gye").on('ifChecked',function (event) {
//   chart.categorizedBySeries(true);
// });
// $ ("#uio").on('ifChecked',function (event) {
//   chart.categorizedBySeries(false);
// });
// Get models. models contains enums that can be used.

// var models = window['powerbi-client'].models;

// var embedConfiguration = {
//   type: 'report',
//   id: '10033FFFA62BAA3E',
//   embedUrl: 'https://app.powerbi.com/reportEmbed',
//   tokenType: models.TokenType.Embed,
//   accessToken: 'h4...rf'
// };

// var $reportContainer = $('#reportContainer');
// var report = powerbi.embed($reportContainer.get(0), embedConfiguration);




// let loadedResolve, reportLoaded = new Promise((res, rej) => { loadedResolve = res; });
// let renderedResolve, reportRendered = new Promise((res, rej) => { renderedResolve = res; });

// // Get models. models contains enums that can be used.
// models = window['powerbi-client'].models;

// // Embed a Power BI report in the given HTML element with the given configurations
// // Read more about how to embed a Power BI report in your application here: https://go.microsoft.com/fwlink/?linkid=2153590
// function embedPowerBIReport() {
//     // Read embed application token
//     let accessToken = EMBED_ACCESS_TOKEN;

//     // Read embed URL
//     let embedUrl = EMBED_URL;

//     // Read report Id
//     let embedReportId = REPORT_ID;

//     // Read embed type from radio
//     let tokenType = TOKEN_TYPE;

//     // We give All permissions to demonstrate switching between View and Edit mode and saving report.
//     let permissions = models.Permissions.All;

//     // Create the embed configuration object for the report
//     // For more information see https://go.microsoft.com/fwlink/?linkid=2153590
//     let config = {
//         type: 'report',
//         tokenType: tokenType == '0' ? models.TokenType.Aad : models.TokenType.Embed,
//         accessToken: accessToken,
//         embedUrl: embedUrl,
//         id: embedReportId,
//         permissions: permissions,
//         settings: {
//             panes: {
//                 filters: {
//                     visible: true
//                 },
//                 pageNavigation: {
//                     visible: true
//                 }
//             }
//         }
//     };

//     // Get a reference to the embedded report HTML element
//     let embedContainer = $('#embedContainer')[0];

//     // Embed the report and display it within the div container.
//     report = powerbi.embed(embedContainer, config);

//     // report.off removes all event handlers for a specific event
//     report.off("loaded");

//     // report.on will add an event handler
//     report.on("loaded", function () {
//         loadedResolve();
//         report.off("loaded");
//     });

//     // report.off removes all event handlers for a specific event
//     report.off("error");

//     report.on("error", function (event) {
//         console.log(event.detail);
//     });

//     // report.off removes all event handlers for a specific event
//     report.off("rendered");

//     // report.on will add an event handler
//     report.on("rendered", function () {
//         renderedResolve();
//         report.off("rendered");
//     });
// }

// embedPowerBIReport();
// await reportLoaded;

// // Insert here the code you want to run after the report is loaded

// await reportRendered;

// // Insert here the code you want to run after the report is rendered

