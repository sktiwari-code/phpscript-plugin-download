<?php

function readCSV($filename)
{
                if (($open = fopen("uploadcsv/".$filename, "r")) !== FALSE) 
                    {
                    
                        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                        {        
                        $array[] = $data; 
                        }
                    
                        fclose($open);
                    }
                   return $array;
}

function crawlMoodlePlugin($filename,$moodleversion)
{
        $data=array();
        $url = 'https://moodle.org/plugins/'.$filename;
        $fields = array(
                    'moodle_version' => $moodleversion
                );
        
        //url-ify the data for the POST
        $fields_string = http_build_query($fields);
        
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        
        //execute post
        $result = curl_exec($ch);
        preg_match_all('/(class="moodleversions")/', $result, $checkarray);
        if(!empty($checkarray[0][0]))
        {
            preg_match_all('/(class="download btn btn-success my-2 mr-1 latest"(.*)?>.*<\/a>)/', $result, $output_array);
            $data["short_name"]=$filename;
            $data["result"]="Yes";
            $data["downloadlink"]=$output_array[2][0];
        }
        else
        {
            $data["short_name"]=$filename;
            $data["result"]="No";
            $data["downloadlink"]="";
        }
        return $data;
        //close connection
        curl_close($ch);
}


?>