<?php
        // file path
        $file_array = file('output.txt');
        $count = 0;

        $name_array;
        $case_array;
        $date;
        $cause;
        foreach($file_array as $key => $value)
        {
            if(($key % 4) == 0) {
                $name_array = explode(', ', str_replace('"', '', substr($value, strpos($value, '[') + 1, -2)));
            } else if(($key % 4) == 1) {
                $case_array = explode(',', substr($value, strpos($value, '"') + 1, -2));
                print_r($case_array);
            } else if(($key % 4) == 2) {
                $date = substr($value, strpos($value, '"'), strrpos($value, '"'));
            } else if(($key % 4) == 3) {
                $cause = substr($value, strpos($value, '"'), strrpos($value, '"'));

                // transaction
                // print_r(array(
                //     'year' => $case_array[0],
                //     'case' => $case_array[1],
                //     'no' => $case_array[2],
                //     'cause' => $cause,
                // ));
                // foreach($name_array as $name) {
                //     print_r(
                //         array(
                //             'jid' => $jid,
                //             'name' => $name
                //         )
                //     );
                // }
            }

        }