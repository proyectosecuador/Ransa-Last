<?php
require '../extensiones/PhpSpreadSheet/autoload.php';
require '../controladores/checklistbpa.controlador.php';
require '../modelos/checklistbpa.modelo.php';

use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// require __DIR__ . '/../Header.php';

if (isset($_POST["idcheckbpa"])) {
    
    $rpta = ControladorCheckListBpa::ctrConsultarCheckListBpa($_POST["idcheckbpa"],"idchcklstbpa");
    /*===================================================================
    =            VARIABLES PARA SUMAR EL TOTAL DE CHECK LIST            =
    ===================================================================*/
    $docpuntobtenido = 0;
    $olpuntobtenido = 0;
    $almprodpuntobtenido = 0;

    for ($i=0; $i < 7 ; $i++) {
        $item = $i+1;
        $docpuntobtenido += $rpta[0]["doc".$item];
    }
    for ($i=0; $i < 12 ; $i++) { 
        $item = $i+1;
        $olpuntobtenido += $rpta[0]["ol".$item];
    }
    for ($i=0; $i < 13 ; $i++) { 
        $item = $i+1;
        $almprodpuntobtenido += $rpta[0]["almprod".$item];
    }
    /* PORCENTAJES OBTENIDOS */
    $pordoc = ($docpuntobtenido / 14)*100;
    $porol = ($olpuntobtenido / 24)*100;
    $poralmprod = ($almprodpuntobtenido / 26)*100;

    $anio = date("Y",strtotime($rpta[0]["fecha_reg"]));
    // $mes = date("m",strtotime($rpta[0]["fecha_reg"]));

    $datos = array();

    array_push($datos, array('',$anio),
                        array('Documentos de Calidad',number_format($pordoc,0,",",".")),
                        array('Orden y Limpieza',number_format($porol,0,",",".")),
                        array('Almacén de Productos',number_format($poralmprod,0,",",".")));
    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    $worksheet->fromArray($datos);

    // Set the Labels for each data series we want to plot
    //     Datatype
    //     Cell reference for data
    //     Format Code
    //     Number of datapoints in series
    //     Data values
    //     Data Marker
    $dataSeriesLabels = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$1', null, 1), // año
    ];
    // Set the X-Axis Labels
    //     Datatype
    //     Cell reference for data
    //     Format Code
    //     Number of datapoints in series
    //     Data values
    //     Data Marker
    $xAxisTickValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$2:$A$4', null, 3), 
    ];
    // Set the Data values for each data series we want to plot
    //     Datatype
    //     Cell reference for data
    //     Format Code
    //     Number of datapoints in series
    //     Data values
    //     Data Marker
    $dataSeriesValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$B$2:$B$4', null, 1),
    ];

    // Build the dataseries
    $series = new DataSeries(
        DataSeries::TYPE_BARCHART, // plotType
        DataSeries::GROUPING_STANDARD, // plotGrouping
        range(0, count($dataSeriesValues) - 1), // plotOrder
        $dataSeriesLabels, // plotLabel
        $xAxisTickValues, // plotCategory
        $dataSeriesValues        // plotValues
    );
    // Set additional dataseries parameters
    //     Make it a vertical column rather than a horizontal bar graph
    $series->setPlotDirection(DataSeries::DIRECTION_COL);

    // Set the series in the plot area
    $plotArea = new PlotArea(null, [$series]);
    // Set the chart legend
    $legend = new Legend(Legend::POSITION_RIGHT, null, false);

    $title = new Title('RESULTADO DE LA INSPECCIÓN');
    $yAxisLabel = new Title('Porcentaje de Cumplimiento');

    // Create the chart
    $chart = new Chart(
        'chart1', // name
        $title, // title
        $legend, // legend
        $plotArea, // plotArea
        true, // plotVisibleOnly
        DataSeries::EMPTY_AS_GAP, // displayBlanksAs
        null, // xAxisLabel
        $yAxisLabel  // yAxisLabel
    );

    // Set the position where the chart should appear in the worksheet
    $chart->setTopLeftPosition('A7');
    $chart->setBottomRightPosition('K20');

    // Add the chart to the worksheet
    $worksheet->addChart($chart);

    // Save Excel 2007 file
    // $filename = $helper->getFilename(__FILE__);
    // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

    // $callStartTime = microtime(true);
    // $writer->save($filename);
    // $helper->logWrite($writer, $filename, $callStartTime);
    /*===========================================================
    =            CABECERAS PARA DESCARGAR EL ARCHIVO            =
    ===========================================================*/
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
    $writer->setIncludeCharts(true);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="file.xlsx"');
    $writer->save("php://output");    
}