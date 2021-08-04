<?php
ini_set('max_execution_time', 0);
error_reporting(0);
header('Content-Type: application/json');
include_once('helper.php');
$json=array();
$csvdata=array();
if(isset($_POST["plugin_submit"]))
{
    $json['status'] = true;
    $moodle_version = $_POST['moodle_version'];
    $plugin_optionselect = $_POST['plugin_optionselect'];
    if(empty($plugin_optionselect))
    {
        $json['status'] = false;
        $json['errors']['plugin_optionselect'] = "* Please select type";
    }
    
    if(!empty($plugin_optionselect) && $plugin_optionselect == "1")
    {
        if(!isset($_FILES['plugin_csv']['name']) && empty($_FILES['plugin_csv']['name']))
        {
            $json['status'] = false;
            $json['error']['plugin_csv'] = "* Please upload file in XLS Or CSV format.";
        }

            $extension = pathinfo($_FILES['plugin_csv']['name'],PATHINFO_EXTENSION);
            $allowed_ext = ['csv'];
            if(!in_array($extension,$allowed_ext))
            {
                $json['status'] = false;
                $json['error'] = "Please upload file in xls or csv format only.";
            }
        
        if($json['status'] == true)
        {
            $csv_name = date('Y-m-d').rand(1000,9999).'.'.$extension;
            if(move_uploaded_file($_FILES['plugin_csv']['tmp_name'],'uploadcsv/'.$csv_name))
            {
                $csvdata=readCSV($csv_name);
                foreach($csvdata as $val)
                {
                    $json["result"][]=crawlMoodlePlugin($val[1],$moodle_version);
                }

            
            }
            else
            {
                $json['status'] = false;
                $json['error'] = "Some problem occurred. Please try again!";
            }

        }
        
    }
    elseif(!empty($plugin_optionselect) && $plugin_optionselect == "2")
    {
       $plugin_name = $_POST['plugin_name'];
       $json["result"][]=crawlMoodlePlugin($plugin_name,$moodle_version);
    }
    echo json_encode($json);
}

?>