<?php
include ("../classes/config/class.conn.php");
include ("../classes/class.todo.php");
?>
<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
    }
    tr, th, td {
        vertical-align: top;
        text-align:left;
        padding:6px;
    }
   tr th {
        border-bottom:3px #ccc solid;
    }
    td {
        border:dashed #ccc 1px;
    }
    body {
        padding:10px 20px;
        background-color:white;
    }
    table {
        background-color:white;
        border:7px #ccc solid;
        border-collapse: collapse;
    }
    .completed {
        min-width:120px;
    }
    .date {
        min-width:120px;
    }
    tr:nth-child(even) {
    background: rgb(235, 233, 233);
}
</style>
<table width="100%">
    <tr>
        <th class="date">Date</th>
        <th>Title</th>
        <th>Update</th>
        <th>Completed</th> 
        <th class="completed">Done Date</th>        
    </tr>
<?php
$todo_values = new todo_all_for_tomato220;
$todo_values->get_all_todos();
?>
<!--
    <tr>
        <td>2018-03-23</td>
        <td>Create Login</td>
         <td>
            <ol>
                <li>
                    Download good login class
                </li>
                <li>
                    Adapt class to my local app and create user table
                </li>
                <li>
                    Do git commit to github
                </li>
            </ol>
        </td>
        <td>No</td>        
     </tr>


     <tr>
        <td>2018-04-01</td>
        <td>After Creating Tomato</td>
         <td>
            <ol>
                <li>
                    Go to editable tomato view
                </li>
                <li>
                    On refresh retain values in form fields
                </li>
                <li>
                    Do not update databse if values are the same.
                </li>
            </ol>
        </td>
        <td>No</td>        
     </tr>

     <tr>
        <td>2018-04-01</td>
        <td>Assign Keywords to Categories</td>
         <td>
            <ol>
                <li>
                   Assign Keywords to Categories in link tanle
                </li>
            </ol>
        </td>
        <td>No</td>        
     </tr>

    <tr>
        <td>2018-03-21</td>
        <td>Associate keywords upload</td>
        <td>
            <ol>
            <li>
                Keyword form elements builds array of keywords in POST super global array.
            </li>
            <li>
                Create upload classs for keywords with function that uses tomato row id as parameter.
            </li>
            <li>
                Iterate through POST array of keywords and upload keyword id and tomato id to link_tom_to_keywords table.
            </li>
        </ol>
    </td>
        <td>YES<br/>2018-03-23<br/>
        "Upload Keywords Rough"</td>        
    </tr>
-->
</table>