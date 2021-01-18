

<div id="page-wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="row white-box" style="margin-top:0px; margin-bottom: 4px">

                <div class="col-lg-10 col-sm-6 annulation">
                    <marquee>
                        <a href="">

                        </a>
                    </marquee>

                </div>
            </div>
        </div>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title"><?php echo $this->lang['list_trans']; ?></h4></div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo WEBROOT . 'transaction/liste'; ?>">  <?php echo $this->lang['ges_trans']; ?></a>
                    </li>
                    <li class="active"><?php echo $this->lang['list_trans']; ?></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>



        <div class="row">

            <div class="white-box">


        <div align="center"  style="color: grey; font-weight: bold; font-size: 15px; text-decoration: underline;"><?php echo mb_strtoupper($this->lang['yearGest'].$year, "UTF-8");
        ?>
        </div>
                <br>
                <ul class="nav nav-tabs tabs customtab">
                    <li class="tab active">
                        <a href="#mesinfos" data-toggle="tab" >
                <span class="visible-xs">
                    <i class="fa fa-info"></i>
                </span>
                            <span class="hidden-xs"><?php echo $this->lang['listetrans']; ?></span>
                        </a>
                    </li>

                    <li class="tab">
                        <a href="#mdp" data-toggle="tab" >
                <span class="visible-xs">
                    <i class="fa fa-line-chart"></i>
                </span>
                            <span class="hidden-xs"><?php echo $this->lang['graf']; ?></span>


                        </a>

                    </li>

                    <li class="tab">
                        <a href="#tranch" data-toggle="tab">
                                <span class="visible-xs">
                                    <i class="fa fa-bar-chart"></i>
                                </span>

                            <span class="hidden-xs"><?php echo $this->lang['graf2']; ?></span>

                        </a>
                    </li>


                    <li class="tab">
                        <a href="#service" data-toggle="tab">
                                <span class="visible-xs">
                                    <i class="fa fa-bar-chart"></i>
                                </span>

                            <span class="hidden-xs"><?php echo $this->lang['graf0']; ?></span>

                        </a>
                    </li>


                    <li class="tab">
                        <a href="#genre" data-toggle="tab">
                                <span class="visible-xs">
                                    <i class="fa fa-users"></i>
                                </span>

                            <span class="hidden-xs"><?php echo $this->lang['graf3']; ?></span>

                        </a>
                    </li>

                    <li class="tab">
                        <a href="#age" data-toggle="tab">
                                <span class="visible-xs">
                                    <i class="fa fa-pie-chart"></i>
                                </span>

                            <span class="hidden-xs"><?php echo $this->lang['graf4']; ?></span>

                        </a>
                    </li>


                    <li class="tab">
                        <a href="#agence" data-toggle="tab">
                                <span class="visible-xs">
                                    <i class="fa fa-pie-chart"></i>
                                </span>

                            <span class="hidden-xs"><?php echo $this->lang['graf5']; ?></span>

                        </a>
                    </li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="mesinfos">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white-box">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border"><?php echo $this->lang['filtre_periodique']; ?></legend>
                                        <br/>
                                        <form class="form-horizontal" method="POST"
                                              action="<?php echo WEBROOT ?>transaction/liste">

                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <div class="form-group">
                                                    <label for="nom"
                                                           class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['du']; ?></label>
                                                    <div class="col-lg-9 col-sm-8">
                                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy"
                                                               name="datedebut" id="from"
                                                               value="<?php echo $datedebut; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <div class="form-group">
                                                    <label for="nom"
                                                           class="col-lg-3 col-sm-4 control-label"><?php echo $this->lang['au']; ?></label>
                                                    <div class="col-lg-9  col-sm-8">
                                                        <input type="date" class="form-control" placeholder="dd-mm-yyyy"
                                                               name="datefin" id="from"
                                                               value="<?php echo $datefin; ?>"/>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
                                                <button type="submit" class="btn btn-success btn-circle btn-lg"
                                                        title="<?php echo $this->lang['btnseek']; ?>"><i class="ti-search"></i></button>
                                            </div>

                                        </form>
                                    </fieldset>
                                </div>
                            </div>

                        </div>
                        <a href="<?php echo WEBROOT . 'transaction/export/' . $datedebut . '/' . $datefin; ?>" target="_blank"
                           class="btn btn-plus pull-right m-l-20  waves-effect waves-light">
                            <i class="fa fa-file-pdf-o"></i> <?php echo $this->lang['export']; ?>
                        </a>
                        <table class="table table-bordered table-hover table-responsive processing"
                               data-url="<?php echo WEBROOT; ?>transaction/transactionProcessing/<?php echo $datedebut; ?>/<?php echo $datefin; ?>">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang['date_transact']; ?></th>
                                <th><?php echo $this->lang['num_transact']; ?></th>
                                <th><?php echo $this->lang['lemontant'] . '( ' . $_SESSION["devise"] . ' )'; ?></th>
                                <th><?php echo $this->lang['code_client']; ?></th>
                                <th><?php echo $this->lang['numcompte_client']; ?></th>
                                <th><?php echo $this->lang['collecteur']; ?></th>
                                <th><?php echo $this->lang['thEtat']; ?></th>
                                <th><?php echo $this->lang['labAction']; ?></th>

                            </tr>
                            </thead>
                        </table>


                    </div>

                    <div class="tab-pane" id="mdp">
                        <div id="container" style="min-width: px; height: px; margin:  auto;"></div>
                    </div>


                    <div class="tab-pane" id="tranch">
                        <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto;">
                        </div>
                    </div>


                    <div class="tab-pane" id="service">
                        <div id="container5" style="min-width: 310px; height: 400px; margin: 0 auto;">
                        </div>
                    </div>


                    <div class="tab-pane" id="genre">
                        <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
                    </div>


                    <div class="tab-pane" id="age">
                        <div id="container6" style="min-width: 410px; max-width: 600px; height: 400px; margin: 0 auto;"></div>
                    </div>



                    <div class="tab-pane" id="agence">
                        <div class="row">
                            <div class="col-md-12">

                            </div>

                        </div>
                        <!--<a href="<?/*= WEBROOT . 'transaction/export/' . $datedebut . '/' . $datefin; */?>" target="_blank"
                           class="btn btn-plus pull-right m-l-20  waves-effect waves-light">
                            <i class="fa fa-file-pdf-o"></i> <?/*= $this->lang['export']; */?>
                        </a>-->
                        <style>
                            .jumbotron{background-color: #FFF;}
                            .card-elan {
                                /* Add shadows to create the "card" effect */
                                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                                transition: 0.3s;
                                border-radius:5%;
                                border-top: solid 3px green;
                                /*border-right: solid 3px green;
                                border-bottom: solid 3px orange;
                                border-left: solid 3px orange;*/
                            }
                            .underline{border-bottom: 1px dashed gray}

                            /* On mouse-over, add a deeper shadow */
                            .card-elan:hover {
                                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                            }

                            /* Add some padding inside the card container */
                            .container-card-elan {
                                padding: 2px 16px;
                            }
                        </style>
                        <div class="jumbotron">
                            <div class="row w-100">
                                <?php foreach ($agencesDays  as $agencesDay) : ?>
                                <div class="col-md-4">

                                    <div class="card-elan">
                                        <div class="container container-card-elan">
                                            <span class="fa fa-info-circle" aria-hidden="false" title="Infos sur le nombre de transaction(s) de l'agence : <?php echo $agencesDay->label.'.'; ?>"></span>
                                            <div class="col-md-12 col-sm-12 underline">
                                                <div class="col-md-6 col-sm-12"><h4 class="text-left"><?php echo $this->lang['agence_code']; ?> :</h4></div>
                                                <div class="col-md-6 col-sm-12"><h4 class="text-left"><b><?php echo '#'.$agencesDay->code ;?></b></h4></div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 underline">
                                                <!--<div class="col-md-6 col-sm-12"><h4 class="text-left"><?php /*echo $this->lang['agence_libelle']; */?> :</h4></div>-->
                                                <!--<div class="col-md-6 col-sm-12"><h4 class="text-left"><b><?php /*echo $agencesDay->label;*/?></b></h4></div>-->
                                                <h4 class="text-center"><b><?php echo $agencesDay->label;?></b></h4>
                                            </div>
                                            <div class="col-md-6"><h4 class="text-left"><?php echo $this->lang['lbl_transaction']; ?> :</h4></div>
                                            <div class="col-md-6"><p class="text-left"><b><?php echo $agencesDay->nb ;?></b></p></div>
                                        </div>
                                    </div>

                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<script src="<?php echo ASSETS ?>js/highcharts.js"></script>
<script src="<?= ASSETS ?>js/highcharts-3d.js"></script>
<script src="<?= ASSETS ?>js/cylinder.js"></script>
<script src="<?= ASSETS ?>js/funnel3d.js"></script>
<script src="<?= ASSETS ?>js/pyramid3d.js"></script>
<script src="<?= ASSETS ?>js/exporting.js"></script>
<script src="<?= ASSETS ?>js/export-data.js"></script>


<!--<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/funnel.js"></script>-->
<!---->
<!---->
<!---->
<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
<!--<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/export-data.js"></script>-->



<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
<!--<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/cylinder.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/funnel3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/pyramid3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/export-data.js"></script>-->




<script>



    /////////////// Courbe montant transactions ///////////////

    Highcharts.chart('container', {
        chart: {
            type: 'spline'
        },
        title: {
            text:"<?php echo $this->lang['graf']; ?>"
        },
        subtitle: {
            text: 'Source: meczy.sn'
        },
        xAxis: {
            categories: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin',
                'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "<?php echo $this->lang['graf']." ( ".$_SESSION["devise"]." )" ;?>"
            },
            labels: {
                formatter: function () {
                    return this.value ;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Transactions',
            marker: {
                symbol: 'square'
            },

            data:[<?php echo $mnt1;?>]

        }]
    });

    /////////////// nombre transaction /////////////

    Highcharts.chart('container1', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: "<?php echo $this->lang['graf2']; ?>"
        },
        subtitle: {
            text: 'Source: meczy.sn'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: Highcharts.getOptions().lang.shortMonths,
            labels: {
                skew3d: true,
                style: {
                    fontSize: '15px'
                }
            }
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Transactions ',
            data: [<?php echo $nbrT; ?>]
        }]
    });



    ////////////Nombre de transaction par genre /////////////////////

    Highcharts.chart('container2', {

        chart: {
            type: 'column'
        },
        title: {
            text: "<?php echo $this->lang['graf3']; ?>"
        },
        subtitle: {
            text: 'Source: meczy.sn '
        },
        xAxis: {
            categories: [
                'Janv',
                'Fev',
                'Mars',
                'Avr',
                'Mai',
                'Juin',
                'Juil',
                'Août',
                'Sept',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Transactions (Nbr.)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<i class="fa fa-male" aria-hidden="true"></i> <?php echo $this->lang["Homme"]; ?>',
            data: [<?php echo $nbrTGM; ?>]

        },
            {
                name: ' <i class="fa fa-female" aria-hidden="true"></i> <?php echo $this->lang["Femme"]; ?>',
                data: [<?php echo $nbrTGF; ?>]

            },

            {
                name: ' <i class="fa fa-university" aria-hidden="true"></i> <?php echo $this->lang["Indefini"]; ?>',
                data: [<?php echo $nbrTGI; ?>]

            }

        ]
    });




    //////////////////// Chart par service New BALDE Enrolement et Dépôt /////////////////////

    var lajson = <?php echo $services; ?>;

    Highcharts.chart('container5', {

        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $this->lang['graf0']; ?>'
        },
        xAxis: {
            categories: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $this->lang['totServ']; ?>'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            }
        },
        series:lajson
    });




    //////////////////// Chart par service New BALDE Enrolement et Dépôt /////////////////////



    ///////////////////////// Transactions par tranches d'age ///////////////////////////////




    //Highcharts.chart('container33', {
    //
    //
    //chart: {
    //    type: 'pyramid'
    //},
    //title: {
    //    text: "<?php //echo $this->lang['graf4']; ?>//"+ " <br /> <br /> " +"<span style='font-size:12px; color: #666666; fill: #666666;'>Source: meczy.sn</span> "+ " <br />",
    //    x: -50
    //},
    //plotOptions: {
    //    series: {
    //        dataLabels: {
    //            enabled: true,
    //            format: '<b>{point.name}</b> ({point.y:,.0f})',
    //            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
    //            softConnector: true
    //        },
    //        center: ['40%', '50%'],
    //        width: '80%'
    //    }
    //},
    //legend: {
    //    enabled: false
    //},
    //series: [{
    //    name: 'Transactions ',
    //    data: [
    //        ['<?php //echo $this->lang["yearOne"]; ?>//', parseInt(<?php //echo $nbr18T; ?>//)],
    //        ['<?php //echo $this->lang["yearTwo"]; ?>//', parseInt(<?php //echo $nbr35T; ?>//)],
    //        ['<?php //echo $this->lang["yearTree"]; ?>//', parseInt(<?php //echo $nbr59T; ?>//)],
    //        ['<?php //echo $this->lang["yearFour"]; ?>//', parseInt(<?php //echo $nbr60T; ?>//)]
    //    ]
    //}]
    //  });

    /////////////////////// transactions par service //////////////////////////////////

    Highcharts.chart('container6', {
        chart: {
            type: 'pyramid3d',
            options3d: {
                enabled: true,
                alpha: 10,
                depth: 50,
                viewDistance: 50
            }
        },
        title: {
            text: "<?php echo $this->lang['graf4']; ?>"+ " <br /> <br /> " +"<span style='font-size:12px; color: #666666; fill: #666666;'>Source: meczy.sn</span> "+ " <br />"
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b> ({point.y:,.0f})',
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    allowOverlap: true,
                    x: 10,
                    y: -5
                },
                width: '60%',
                height: '80%',
                center: ['50%', '45%']
            }
        },
        series: [{
            name: "<?php echo $this->lang['lbl_transaction']; ?>",
            data: [
                ['<?php echo $this->lang["yearOne"]; ?>',  parseInt(<?php echo $nbr18T; ?>)],
                ['<?php echo $this->lang["yearTwo"]; ?>', parseInt(<?php echo $nbr35T; ?>)],
                ['<?php echo $this->lang["yearTree"]; ?>', parseInt(<?php echo $nbr59T; ?>)],
                ['<?php echo $this->lang["yearFour"]; ?>', parseInt(<?php echo $nbr60T; ?>)]
            ]
        }]
    });



</script>


<style>
    legend.scheduler-border {
        font-size: 1.1em !important;
        font-weight: normal !important;
        text-align: left !important;
        border-bottom: none;
        background-color: #0a7242;
        color: #fff;
        padding: 5px 30px;
        display: block;
        width: auto;
        margin-bottom: auto;}

    .btn-plus, .btn-plus.disabled {
        background: #0a7242;!important;
        margin-bottom: 10px;!important;
  }
</style>

