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
      <div class="row" id="search_form">
        <form action="<?= $_SERVER['SCRIPT_NAME'] ?>" method="GET">
          <label for="search_string">Поиск:</label>
          <input name="search_string" type="text" value="" maxlength="200"/>
          <input name="do_search" type="submit" value="Найти"/>
        </form>
      </div>
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
                <td><?=$s->firstName?></td>
                <td><?=$s->lastName?></td>
                <td><?=$s->group?></td>
                <td><?=$s->mark?></td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
