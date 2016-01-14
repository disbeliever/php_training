<!doctype html>
<html lang="ru">

  <head>
    <title>Список студентов</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <a href="ControllerStudent.php">Регистрация</a>
      </div>
      <div class="row" id="search_form">
        <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="GET" class="form-inline">
          <div class="form-group">
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
      <div class="row" id="students_table">
        <div class="col-sm-8">
          <table id="students" class="table">
            <tr>
              <th>Имя</th>
              <th>Фамилия</th>
              <th>Номер группы</th>
              <th>Баллов</th>
            </tr>
            <?php foreach ($students as $s): ?>
              <tr>
                <td>
                  <a href="/ControllerStudent.php?id=<?=$s->id?>">
                    <?=htmlspecialchars($s->firstName)?>
                  </a>
                </td>
                <td><?=htmlspecialchars($s->lastName)?></td>
                <td><?=htmlspecialchars($s->group)?></td>
                <td><?=htmlspecialchars($s->mark)?></td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
