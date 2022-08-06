<?php
function test_input($data)
{
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (isset($_REQUEST['db_name'])) {
    $dbname = test_input($_REQUEST['db_name']);
}
//   echo $dbname ;die;

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
// $dbname = 'new_db';
$tables = '*';

//Call the core function
backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);

//Core function
function backup_tables($host, $user, $pass, $dbname, $tables = '*')
{
    $link = mysqli_connect($host, $user, $pass, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    $return = '';
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        // $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";
        $counter = 1;

        //Over tables
        for ($i = 0; $i < $num_fields; $i++) {   //Over rows
            while ($row = mysqli_fetch_row($result)) {
                if ($counter == 1) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                } else {
                    $return .= '(';
                }

                //Over fields
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }

                if ($num_rows == $counter) {
                    $return .= ");\n";
                } else {
                    $return .= "),\n";
                }
                ++$counter;
            }
        }
        $return .= "\n\n\n";
    }

    //save file
    $fileName = 'db-backup-' . $dbname . '-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';
    $fileNamezip = 'db-backup-' . $dbname . '-' . time() . '-' . (md5(implode(',', $tables)));


    $zip = new ZipArchive();
    $handle =  fopen('G:/My Drive/db_backup/' . $fileName, "w+");

    fwrite($handle, $return);
    if (fclose($handle)) {


        // $zip->open('G:/My Drive/db_backup/zip/'.$fileNamezip.'.zip', ZipArchive::CREATE);
        // $zip->setPassword('secret');
        // $zip->addFile('G:/My Drive/db_backup/'.$fileName,$fileName);
        // $zip->setEncryptionName('G:/My Drive/db_backup/'.$fileName, ZipArchive::EM_AES_256,'password');
        // $zip->close();
        //  php cmdline_example.php -e abc.txt;


        // $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';

        // function my_encrypt($data, $key) {
        //     $encryption_key = base64_decode($key);
        //     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        //     $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        //     return base64_encode($encrypted . '::' . $iv);
        // }

        // function my_decrypt($data, $key) {
        //     $encryption_key = base64_decode($key);
        //     list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        //     return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // }


        // $code = file_get_contents('G:/My Drive/db_backup/'.$fileName); //Get the code to be encypted.
        // $encrypted_code = my_encrypt($code, $key); //Encrypt the code.
        // echo 'Encrypted Code <br><br>';
        // echo $encrypted_code;

        // file_put_contents('G:/My Drive/db_backup/enc/'.$fileName, $encrypted_code); //Save the ecnypted code somewhere.

        // $encrypted_code = file_get_contents('path/to/save/encrypted_code.php'); //Get the encrypted code.
        // $decrypted_code = my_decrypt($encrypted_code, $key);//Decrypt the encrypted code.
        // echo 'Decrypted Code <br><br>';
        // echo $decrypted_code;

        // file_put_contents('path/to/save/code.php', $decrypted_code); //Save the decrypted code somewhere.



        // Configuration settings for the key
        // $config = array(
        //     "digest_alg" => "sha512",
        //     "private_key_bits" => 4096,
        //     "private_key_type" => OPENSSL_KEYTYPE_RSA,
        // );

        // Create the private and public key
        // $res = openssl_pkey_new($config);

        // Extract the private key into $private_key
        // openssl_pkey_export($res, $private_key);
        // openssl_pkey_export_to_file($private_key, 'D:/xampp/htdocs/ehtesham_task/openssl/privatekey.pem'); //saving prvt key in file
        // Extract the public key into $public_key
        // $public_key = openssl_pkey_get_details($res);
        // $public_key = $public_key["key"];
        // $cert = openssl_csr_new($config, $privkey);
        // $cert = openssl_csr_sign($cert, null, $privkey, 365);
        // openssl_x509_export_to_file($public_key, 'D:/xampp/htdocs/ehtesham_task/openssl/publickey.pem'); // saving public key

        // Encrypt using the public key
        // $code = file_get_contents('G:/My Drive/db_backup/' . $fileName); //Get the code to be encypted.
        // if (openssl_public_encrypt($code, $encrypted_data, $public_key, OPENSSL_NO_PADDING) == true) {
        //     echo "enc done";
        // } else echo "enc failed";

        // fopen('G:/My Drive/db_backup/enc/' . $fileName, "w+");
        // $encrypted_data   =  file_put_contents('G:/My Drive/db_backup/enc/' . $fileName, $encrypted_data); //Save the ecnypted code somewhere.

        // $encrypted_hex = bin2hex($encrypted_data);
        // echo "This is the encrypted text: $encrypted_hex\n\n";
        // echo "This is the encrypted text: $encrypted_data\n\n";

        // Decrypt the data using the private key
        // openssl_private_decrypt($encrypted_data, $decrypted, $private_key);

        // echo "This is the decrypted text: $decrypted\n\n";
        // echo "1";



        $Configs = array(
            'digest_alg' => 'sha1',
            'x509_extensions' => 'v3_ca',
            'req_extensions' => 'v3_req',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => true,
            'encrypt_key_cipher' => OPENSSL_CIPHER_3DES
        );

        //generate cert
        $dn        = array('commonName' => 'test');
        $privkey   = openssl_pkey_new($Configs);
        $csr       = openssl_csr_new($dn, $privkey, $Configs);
        $cert      = openssl_csr_sign($csr, null, $privkey, 365, $Configs);
        $publicKey = openssl_pkey_get_public($cert);
        openssl_x509_export_to_file($cert, 'D:/xampp/licenses/openssl/publickey.pem');
        openssl_pkey_export_to_file($privkey, 'D:/xampp/licenses/openssl/privatekey.pem');
        $code = file_get_contents('G:/My Drive/db_backup/' . $fileName); //Get the code to be encypted.
        if (openssl_public_encrypt($code, $encrypted_data, file_get_contents('D:/xampp/licenses/openssl/publickey.pem'), OPENSSL_NO_PADDING) == true) {
            echo "enc done";
        } else echo "enc failed";

        // var_dump($publicKey);


        exit;
    }
}