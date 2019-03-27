<?php
define('DB_NAME','C:\xampp\htdocs\crud\Data\db.txt');
function seed(){
    $data=array(
        array(
            "id"=>"1",
            "fname"=>"kamal",
            "lname"=>"Ahmed",
            "roll" =>'11'
        ),
        array(
            "id"=> 2,
            "fname"=>"Jamal",
            "lname"=>"Ahmed",
            "roll" =>'12'
        ),
        array(
            "id"=> 3,
            "fname"=>"Ripon",
            "lname"=>"Ahmed",
            "roll" =>'13'
        ),
        array(
            "id"=>4,
            "fname"=>"Sumon",
            "lname"=>"Ali",
            "roll" =>'14'
        ),
    );
    $serializeData=serialize($data);
    file_put_contents(DB_NAME,$serializeData,LOCK_EX);
}

function generateReport()
{
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    ?>
    <table>
        <tr>
            <th width="50%">Name</th>
            <th width="20%">Roll</th>
            <th width="30%">Action</th>
        </tr>
        <?php
        foreach ($students as $student) {
            ?>
            <tr>
                <td><?php printf("%s %s", $student['fname'], $student['lname']); ?></td>
                <td><?php printf("%d", $student['roll']); ?></td>
                <td><?php printf('<a href="\crud\index.php?task=edit&id=%s">Edit</a>|<a href="\crud\index.php?task=delete&id=%s">Delete</a>', $student['id'], $student['id']); ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
    function addnewstudent($fname,$lname,$roll){
    $found=false;
        $serializeData=file_get_contents(DB_NAME);
        $students=unserialize($serializeData);
        foreach($students as $_student){
            if($_student["roll"]==$roll){
                $found=true;
                break;
            }
        }
        if(!$found) {
            $newId = count($students) + 1;
            $student = array(
                'id' => $newId,
                'fname' => $fname,
                'lname' => $lname,
                'roll' => $roll,
            );
            array_push($students, $student);
            $serializeData = serialize($students);
            file_put_contents(DB_NAME, $serializeData, LOCK_EX);
            return true;
        }
        return false;
    }
