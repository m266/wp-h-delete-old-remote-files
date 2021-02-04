<?php
// Quelle: https://www.carnaghan.com/knowledge-base/php-script-that-deletes-files-within-a-remote-directory-via-ftp-older-than-a-given-amount-of-days/

$host = $server_0; //Replace with your host
$username = $benutzer_1; //Replace with your username
$password = $passwort_2; //Replace with your password
$mode = "passive"; //Leave blank to go to active mode
$dir = $pfad_auf_dem_server_3; //Put the name of the directory in here where you want to loop through files, put / for root directory
$daysOld = $intervall_tage_4; //Enter the age of files in days, if a file should be deleted that's older than 2 days enter 2
//$filesToSkip = array('.','..','.ftpquota'); //Contains the files that the script needs to skip if it comes accross them
$email = get_option('admin_email'); // Admin-E-Mail
$notificationEmail = $email; //The email address to send a notification when file fails to delete (Admin)

//FTP session starting
$connection = ftp_connect($host);
$login = ftp_login($connection,$username,$password);
if(!$connection || !$login){
// Fehlermeldung bei fehlenden Angaben
function wphdorf_error() {
?>
<div class="notice notice-error">
    <p><b>Bitte korrekte Daten im Plugin "WP H-Delete old Remote Files" f&uuml;r den FTP-Zugang eingeben!</b></p>
</div>
<?php
}
add_action('admin_notices', 'wphdorf_error');
}
else {
if($mode == 'passive'){
    //Switching to passive mode
    ftp_pasv($connection,TRUE);
}else{
    ftp_pasv($connection,FALSE);
}

//Calcuting the datetime of todays day minus the amount of 2days entered
$dateToCompare = date('Y-m-d',  strtotime('-'.$daysOld.' days',time()));

//Looping through the contents of the provided directory
 $files = ftp_nlist($connection,$dir); //ftp_rawlist — Returns a detailed list of files in the given directory
 foreach($files as $file){
     //Check if the file is in the list of files to skip, if it is we continue the loop
     if(in_array($file, $filesToSkip)){
         continue;
     }
     $modTime = ftp_mdtm($connection, $file);

// Ausführung einmal täglich: if (date("H") == "00")
//if (date("i") == "24") {
     if(strtotime($dateToCompare) >= $modTime){
         if(!ftp_delete($connection,$file)){ //Deleting the file that needs to be deleted
             //If the file fails to delete we send a mail to the administrator
             mail($notificationEmail, 'FEHLER BEIM LÖSCHEN DER DATEI: '.$file);
         }
     }
//}
 }
}
ftp_close($connection);
?>