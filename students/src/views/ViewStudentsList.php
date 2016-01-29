<!doctype html>
<html lang="ru">

  <head>
    <title>Список студентов</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/custom.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
      </div>
      <div class="row row-centered" id="search_form">
        <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="GET" class="form-inline">
          <div class="form-group">
            <button class="btn"><a href="ControllerStudent.php">Регистрация</a></button>
            <label for="searchString">Поиск:</label>
            <input name="searchString" type="text" class="form-control" value="" maxlength="200"/>
          </div>
          <button class="btn btn-default" type="submit">Найти</button>
        </form>
      </div>
      <?php if ($searchString != ""):?>
        <div>
          <p>Показаны только абитуриенты, найденные по запросу «<?=htmlspecialchars($searchString)?>». </p>
          <p><a href="<?=$_SERVER['SCRIPT_NAME']?>">[Показать всех абитуриентов]</a></p>
        </div>
      <?php endif; ?>
      <div class="row row-centered" id="students_table">
        <div class="col-sm-8 col-centered">
          <table id="students" class="table">
            <tr>
              <th>
                <a href="<?=htmlspecialchars(getSortingURL($searchString, 'first_name', $sortDir, $page), ENT_QUOTES)?>">
                  Имя <?=getSortDirGlyph('first_name', $sortDir)?>
                </a>
              </th>
              <th>
                <a href="<?=htmlspecialchars(getSortingURL($searchString, 'last_name', $sortDir, $page), ENT_QUOTES)?>">
                  Фамилия <?=getSortDirGlyph('last_name', $sortDir)?>
                </a>
              </th>
              <th>
                <a href="<?=htmlspecialchars(getSortingURL($searchString, 'student_group', $sortDir, $page), ENT_QUOTES)?>">
                  Номер группы <?=getSortDirGlyph('student_group', $sortDir)?>
                </a>
              </th>
              <th>
                <a href="<?=htmlspecialchars(getSortingURL($searchString, 'mark', $sortDir, $page), ENT_QUOTES)?>">
                  Баллов <?=getSortDirGlyph('mark', $sortDir)?>
                </a>
              </th>
            </tr>
            <?php foreach ($students as $s): ?>
              <tr>
                <td>
                  <a href="ControllerStudent.php?id=<?=$s->id?>">
                    <?=htmlspecialchars($s->firstName)?>
                  </a>
                </td>
                <td><?=htmlspecialchars($s->lastName)?></td>
                <td><?=htmlspecialchars($s->group)?></td>
                <td><?=htmlspecialchars($s->mark)?></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
      <div class="row row-centered">
        <ul class="pagination">
          <?php for ($i=1;$i < $pager->getTotalPages();$i++): ?>
          <li><a href="<?=$pager->getLinkForPage($i)?>"><?=$i?></a></li>
          <?php endfor; ?>
        </ul>
      </div>
    </div>
  </body>
</html>
