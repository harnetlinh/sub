<?php
$client->addScope(array(
                'https://www.googleapis.com/auth/drive.file',
    //            'https://www.googleapis.com/auth/plus.login',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/drive.metadata',
                'https://www.googleapis.com/auth/drive',
                'https://www.googleapis.com/drive/v3/files/fileId'
            ));