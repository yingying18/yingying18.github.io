<?php
error_reporting(0);
$con = mysql_connect("setapproject.org","csc412","csc412");
if($con)
{
    mysql_select_db("wchen_quotes",$con);
}

if(isset($_POST["save"]))
{
    $sql = mysql_query("INSERT INTO wchen_quotes(fullname, quote) VALUES('{$_POST['fullname']}','{$_POST['quote']}')");
    if ($sql)
    {
        echo "Save Successfully";
    }
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            Visitor Page
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="site.css">
        <style type="text/css"></style>
    </head>
    <body>
        <form action="" method="post">
            <table style="border:solid; width:500px; overflow:auto; margin:auto;">
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="fullname" value="<?php echo $rows->fullname; ?>" /></td>
                </tr>
                <tr>
                    <td>Quote:</td>
                    <td><input type="text" name="quote" value="<?php echo $rows->quote; ?>" /></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Save" name="save" />
                    </td>
                </tr>
            </table>
            <table style="border:solid; width:500px; overflow:auto; margin:auto;">
                <thead>
                    <th>Name</th>
                    <th>Quote</th>
                </thead>
                <tbody>
                    <?php
                        $sqlshow = mysql_query("SELECT * FROM wchen_quotes");
                        while($row = mysql_fetch_object($sqlshow))
                        {
                            echo "<tr><td>$row->fullname</td><td>$row->quote</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </body>
</html>

