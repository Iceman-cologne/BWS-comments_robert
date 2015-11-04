<?php

ini_set("display_errors", 0);
session_start();
$interviewID = session_id();
$debugFeedback ="";
$password="test";
$login= false;
$file_feedback ="feedback/" . $interviewID . ".json";
$current ="";
$counterstand =0;
$feedback_json = "";
$page ="1";

//Open data for counter as txt. file 
$datei = fopen("counter.txt", "r+");
$counterstand = fgets($datei, 100);
$counterstand = intval($counterstand);

    if ($counterstand >=12) {
        $counterstand = 0;
    }
    if(!isset($_SESSION['counter_ip'])) {
    $counterstand++;
    $datei = fopen("counter.txt", "w+");
    rewind($datei);
    fwrite($datei, $counterstand);
    $_SESSION['counter_ip'] = true; 
    fclose($datei); 
    }

// Password validation
    if (isset($_POST['password']) && $_POST['password'] == $password) {   
    } else {  
    header('Location:index.php'); 
    }

// Validate feedback textarea and open JSON file to save the comment     
if (isset($_REQUEST["debugFeedback"]) && !empty($_REQUEST["debugFeedback"])){
    $current = $_REQUEST["debugFeedback"];
    $feedback_json = json_encode($current); // encode to JSON 
    file_put_contents($file_feedback, $feedback_json, FILE_APPEND | LOCK_EX); //use of file_put_contents open and close JSON file
} else {
    file_put_contents($file_feedback, $debugFeedback);
}


?>

<!-- Html code -->  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Fragebogen</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="Scripts/jquery-2.0.3.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
<!-- css inline style for index1.php -->
    <style type="text/css">
            h2.debug { background-color: #BBAABB; color: #FFFFFF; padding: 2px 10px 0px 10px; margin-bottom: 0px }
            div.debug   { margin: 0px 0px 32px 0px; padding: 8px 8px 6px 8px; border: 2px solid #BBAABB; color: #999999 }
            div.debug p { margin: 0px 0px 7px 0px }
            
            @media print {
                h2.debug,
                div.debug { display: none }
            }
    
    </style>


<style type="text/css">
    div.SoSciDebug.question,
            div.SoSciDebug.textelement {
                position: relative; width: 100%; font-family: Verdana, Arial, sans-serif; font-size: 12px; font-weight: normal; color: #000000;
            }
            div.SoSciDebug.question:hover,
            div.SoSciDebug.question:focus {
                z-index: 10
            }
            div.SoSciDebug.question div.container,
            div.SoSciDebug.textelement div.container {
                position: absolute;
                width: 60px; top: -8px;
                left: 100%;
                padding-left: 20px;
            }
            div.SoSciDebug.textelement div.container {
                min-width: 60px; width: auto;
                left: 100%;
                padding-left: 20px;
            }
            div.SoSciDebug.question.notes div.container,
            div.SoSciDebug.question div.container:hover {
                width: 200px;
            }
            div.SoSciDebug.textelement div.container:hover {
                min-width: 200px;
            }
            div.SoSciDebug.question.inside div.container,
            div.SoSciDebug.question.notes.inside div.container {
                width: 60px; left: auto; right: 0;
                opacity: 0.6;
                padding-left: 0;
            }
            div.SoSciDebug.textelement.inside div.container {
                min-width: 60px; width: auto; left: auto; right: 0;
                opacity: 0.6;
                padding-left: 0;
            }
            div.SoSciDebug.question.inside:hover div.container,
            div.SoSciDebug.question.notes.inside:hover div.container {
                width: 200px;
            }
            div.SoSciDebug.textelement.inside:hover div.container {
                min-width: 200px;
            }

            div.SoSciDebug.question div.container div.ballot,
            div.SoSciDebug.textelement div.container div.ballot {
                position: absolute;
                left: 0; top: 8px;
                width: 21px; height: 13px;
                background-image:url(../layout/debug.ballot.svg);
                background-repeat: no-repeat;
            }
            div.SoSciDebug.question.pretest div.container div.ballot,
            div.SoSciDebug.textelement.pretest div.container div.ballot {
                background-image:url(../layout/pretest.ballot.svg);
            }
            div.SoSciDebug.question.inside div.container div.ballot,
            div.SoSciDebug.textelement.inside div.container div.ballot {
                display: none;
            }
            div.SoSciDebug.question div.label,
            div.SoSciDebug.textelement div.label {
                padding: 2px 6px;
                font-weight: bold;
                white-space: nowrap;
            }
            div.SoSciDebug.question div.box,
            div.SoSciDebug.textelement div.box {
                margin: 0;
                box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;
                background-color: #FFCC00;
                border: 1px solid #999999; border-radius: 4px 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px
            }
            div.SoSciDebug.question.pretest div.box,
            div.SoSciDebug.textelement.pretest div.box {
                background-color: #BBAABB;
            }

            div.SoSciDebug.question div.notes {
                margin: 1px;
                background-color: #FFEE66;
                font-size: 10px; padding: 3px; min-height: 56px; height: 56px; overflow: hidden
            }
            div.SoSciDebug.question div.notes.empty { display: none }
            div.SoSciDebug.question div.notes.changed { border-color: #FF9900 }
            div.SoSciDebug.question div.notes.error { border-color: #FF0000 }
            div.SoSciDebug.question div.notes p { font-size: inherit; margin: 4px 0 }
            div.SoSciDebug.question div.notes p:first-child { margin-top: 0 }
            div.SoSciDebug.question div.notes p:last-child { margin-bottom: 0 }
            div.SoSciDebug.question div.notes:hover,
            div.SoSciDebug.question div.notes:focus { height: auto; background-color: #FFFFFF }
            div.SoSciDebug.question div.notes.empty:focus { display: block }
            div.SoSciDebug.question:hover div.notes { height: auto }
            div.SoSciDebug.question:hover div.notes.empty { display: block }

            @media print {
                div.SoSciDebug.question div.container,
                div.SoSciDebug.question.inside div.container {
                    left: auto; right: 0; width: 60px;
                }
                div.SoSciDebug.textelement div.container,
                div.SoSciDebug.textelement.inside div.container {
                    left: auto; right: 0; width: auto; min-width: 60px;
                }
                div.SoSciDebug.question div.container div.ballot,
                div.SoSciDebug.textelement div.container div.ballot {
                    display: none;
                }
                div.SoSciDebug.question div.box,
                div.SoSciDebug.question.pretest div.box,
                div.SoSciDebug.textelement div.box,
                div.SoSciDebug.textelement.pretest div.box {
                    background-color: #EEEEEE; color: #000000;
                    border: 1px solid #000000;
                    opacity: 0.66;
                }
                div.SoSciDebug.question div.label,
                div.SoSciDebug.textelement div.label {
                    font-size: 80%;
                    text-align: center;
                    padding: 1px 3px;
                }
                div.SoSciDebug.question.notes div.container,
                div.SoSciDebug.textelement.notes div.container {
                    width: 60px; right: 0;
                }
            }

    </style>

    <style type="text/css">
    body { padding-bottom: 24px }
            div.questionary { width: 600px; margin: 0px auto }
            hr { height: 2px; border: 0px; background-color: transparent; border-bottom: 2px solid #CCCCCC; margin: 24px 0px 28px 0px; }
            a { text-decoration: none; }
            th { font-weight: bold  !important; display:inline-block; }
            th.value_text { display:table-cell; }
    </style>
</head>



<body style="">
    <div style="background-color: rgb(255, 153, 0); color: rgb(255, 255, 255); font-weight: bold; font-size: 12px; 
                font-family: Verdana, Arial, sans-serif; width: 100%; height: 16px; padding: 4px 10px; border-bottom-width: 
                1px; border-bottom-style: solid; border-bottom-color: rgb(153, 153, 153); 
                position: fixed; top: 0px; left: 0px; z-index: 32000; text-align: center;">Pretest des Fragebogens "base"</div>
    <div style="height: 25px;"></div>
    <div class="questionary">
    <div style="margin-top: 18px;">
    <!-- header -->
    <div style="margin-top: 18px">
        <div style="float:left;width:70%">
            <strong>Universität zu Köln</strong><br><br>
            Professur für Wirtschaftsinformatik<br>
            und integrierte Informationssysteme<br>
            Prof. Dr. Christoph Rosenkranz
        </div>   
        <div style="float:right;width:30%;text-align:right;">
            <img src="https://www.soscisurvey.de/Innovationen_in_ITO/logo.ger.0311.jpg" alt="logo">
        </div>
        <div style="clear:both;"></div>
    </div> 
                    
   
        <form action="index2.php" method="POST" accept-charset="UTF-8" autocomplete="off" id="questionnaireForm">
            <div class="invisible">
                <input type="hidden" name="page" value="2"/>
                <input type="hidden" name="counter" value="<?php echo $counterstand; ?>"/>
            </div>
        

 
        

    <!-- Headline -->
    <hr style="margin-top: 12px;">
        <h1>Evaluation von Faktoren zur Innovationsgewinnung in ITO-Projekten</h1>
            <p>Im Rahmen der folgenden Befragung, möchten wir versuchen, ein besseres wissenschaftliches Verständnis 
            für die Wichtigkeit von einzelnen Faktoren zur Förderung von Innovationen im Rahmen von IT-Outsourcing-Projekten 
            erlangen.</p>
            <p>
                <strong>Die Auswertung der gesamten Studie erfolgt anonym und unter Einhaltung der Bestimmungen des
                Datenschutzgesetzes</strong> und im Rahmen eines wissenschaftlichen Papiers wird es anonymisiert veröffentlicht.
                <br/>
                <br/>
                Die folgende Befragung basiert auf den von Boehm, Michalik, Schmidt und Basten erarbeiteten Faktoren mit
                Einfluss auf die Innovationsgewinnung in IT-Outsourcing- Projekten aus ihrer Arbeit "Innovate on 
                Purpose - Factors Contributing to Innovation in IT Outsourcing" (2014).</p>
                <br/>

            <p style="text-align: center;">
            Universtität zu Köln
            <br/>
            Professur für Wirtschaftsinformatik und integrierte Informationssysteme
            <br/>
            Direktor: Prof. Dr. Christoph Rosenkranz
            <br/>
            Pohligstr. 1, 50969 Köln
            </p>
            <br/>

            <p style="text-align: center;">
            Ansprechpartner:
            <br/>
            Nikolaus Schmidt (Wissenschaftlicher Mitarbeiter) nikolaus.schmidt@wiso.uni-koeln. de
            <br/>
            Aysun Sunay (Master-Student) asunay@smail.uni-koeln.de
            </p>
            <br/>
            <p style="text-align: center;">Pretest im Rahmen der Masterthesis: Empirische Überprüfung eines Frameworks zur Förderung Innovationen in IT-Outsourcing Projekten</p>

        <!-- Debug textfield -->
        <h2 class="debug">Anmerkungen zu Seite 1</h2>
            <div class="debug">
                <p>Sie testen den Fragebogen gerade im Pretest-Modus.</p>
                <p>Fanden Sie auf dieser Seite irgend etwas unverständlich,
                missverständlich oder unklar? Sehen Sie noch irgendwelche Fehler?
                Bitte schreiben Sie hier <strong>alles</strong> auf, was Ihnen auffällt.</p>
                <p>Vielen Dank.</p>

                <div class="textinput">
                <textarea name="debugFeedback" cols="92" rows="8" style="width: 100%; height: 120px; margin-top: 6px"></textarea>
                </div>
                <input name="debugPage" value="1" type="hidden"/>
            </div>


        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="submitButtons" id="buttonsAuto">
            <colgroup>
            <col width="50%">
            <col width="50%">
            </colgroup> 
            <tbody>
                <tr>
                <td class="buttonBack"></td>
                <td class="buttonNext">
                    <input class="button" name="submitNext" id="submit0" type="submit" value="Weiter" title="Weiter"/>
                </td>
            </tr>
            </tbody>
        </table>

    <!-- Footer -->
    <hr style="margin-bottom: 14px;">
    <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">
        <colgroup>
            <col width="350">
            <col width="50">
            <col width="200">
        </colgroup>
        <tr>
            <td>
                <a href="mailto:nikolaus.schmidt@wiso.uni-koeln.de">Nikolaus Schmidt (Wissenschaftlicher
                Mitarbeiter)</a> 
                <br> 
                <a href="mailto:asunay@smail.uni-koeln.de">Aysun Sunay
                (Master-Student)</a>
                <br>
                Universität zu Köln – 2015
            </td>
            <td></td>
            <td>
                <div class="progressbar">
                    <div class="progress" style="width: 0%;"</div>
                        <div class="progresstext">0% ausgefüllt</div>
                    </div>
            </td>
        </tr>
    </table>
    <div>
        <input name="zomplete" value="yes" type="hidden">
    </div>
    </form>
                </div>
</body>
</html>