<?php
require_once "inc/functions.php";
$path = isset($_GET['path']) ? $_GET['path'] : getcwd();
$parentPathArr = explode('\\', $path);
array_pop($parentPathArr);
$parentPath = implode('\\', $parentPathArr);
if (isset($_FILES['newfile'])) {
    move_uploaded_file($_FILES['newfile']['tmp_name'], $path . '\\' . $_FILES['newfile']['name']);
}

if(isset($_POST['remove'])){
    $toRemove = $_POST['remove'];
    if(is_dir($toRemove)){
        rmdir($toRemove);
    } elseif (is_file($toRemove)){
        unlink($toRemove);
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://use.fontawesome.com/debef5cbce.js"></script>
    <style>
        a {
            color: #1873b4;
            text-decoration: none;
        }

        a.navigator {
            display: block;
        }

        a.navigator i {
            margin-right: 5px;
            color: #F2BA34;
        }

        a.navigator.file i {
            margin-right: 5px;
            color: grey;
        }

        a:hover {
            color: #e17009;
        }

        table {
            width: 100%;
        }

        .path-line input {
            width: 100%;
        }

        #fileuploader {
            display: none;
        }

        .toolbar label {
            color: #1873b4;
        }

        .toolbar label:hover {
            color: #e17009;
        }
        button {
            background: none;
            border: none;
            color: #1873b4;
            cursor: pointer;
        }
        button:hover {
            color: #e17009;
        }
    </style>
</head>
<body>
<table style="width: 900px;margin: 0 auto;">
    <tr>
        <td width="50%">
            <table class="panel-path" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td class="path-back">
                        <a href="?path=<?= $parentPath ?>" class="cpanel-sprite-ufm-gray spart-back-on"
                           title="Переместиться на уровень вверх"><i class="fa fa-folder-open fa-2x"
                                                                     aria-hidden="true"></i></a>
                    </td>

                    <td class="path-line">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td><input type="text" value="<?= $path ?>" class="local " readonly="" disabled></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="path-refresh">
                        <div id="ufm_panel_refresh_left" class="cpanel-sprite-ufm-blue spart-refresh"
                             onclick="Ufm.naviRefresh('left');" title="Обновить">&nbsp;</div>
                        <div id="ufm_panel_loader_left" style="display:none;"><img src="/img/cms/loader-circle.gif"
                                                                                   border="0" align="absmiddle"></div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="toolbar">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="fileuploader"><i class="fa fa-upload" aria-hidden="true"></i></label>
                    <input id="fileuploader" type="file" name="newfile">
                </form>
            </div>
            <table>
                <?php
                $dirs = scandir($path);
                if (is_array($dirs))
                    array_shift($dirs);
                foreach ($dirs as $d):
                    $fulld = $path . '\\' . $d;
                    if ($d == '..'):
                        if ($path == getcwd()) {
//                            continue;
                        }
                        echo "<tr><td></td><td><a href='?path=$parentPath'><i class='fa fa-level-up' aria-hidden='true'></i>$d</a></td></tr>";
                    elseif (is_dir($fulld)): ?>
                        <tr>
                            <td class="check"><input type="checkbox" name="check" data-path="/uploads/1.png"></td>
                            <td>
                                <div>
                                    <a href="?path=<?= $fulld ?>" title="Folder"
                                       class="navigator folder"><i class="fa fa-folder"
                                                                   aria-hidden="true"></i><span><?= $d ?></span></a>
                                </div>
                            </td>
                            <td>
                                <form action="" method="post"><input type="hidden" name="remove" value="<?= $fulld ?>">
                                    <button type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            </td>
                            <td><span>Folder</span></td>
                            <td>-</td>
                            <td><span class="date">20.02.2016 15:45</span></td>
                        </tr>

                        <?php
                    endif;
                endforeach;
                foreach ($dirs as $d):
                    $fulld = $path . '\\' . $d;

                    if (is_file($fulld)): ?>
                        <tr>
                            <td class="check"><input type="checkbox" name="check" data-path="/uploads/1.png"></td>
                            <td>
                                <div>
                                    <a href="#" title="File" class="navigator file"><i class="fa fa-file"
                                                                                       aria-hidden="true"></i><span><?= $d ?></span></a>
                                </div>
                            </td>
                            <td>
                                <form action="" method="post"><input type="hidden" name="remove" value="<?= $fulld ?>">
                                    <button type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>
                            <td><span>file</span></td>
                            <td><?= formatBytes(filesize($fulld)) ?></td>
                            <td><span class="date"><?= date("j.m.Y H:i:s", filemtime($fulld)) ?></span></td>
                        </tr>
                        <?php
                    endif;
                endforeach;
                ?>


            </table>
        </td>
        <td width="50%">
            sd
        </td>
    </tr>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $('#fileuploader').change(function (e) {
        $(this).parents('form').submit();
    });
</script>
</body>
</html>