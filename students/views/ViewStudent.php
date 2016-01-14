<!doctype html>
<html lang="ru">

  <head>
    <title>Студент: <?= $student->firstName ?> <?= $student->lastName ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
  </head>

  <body>
    <div class="container-fluid">
      <nav>
        <a href="/index.php">Список абитуриентов</a>
      </nav>
      <div id="register_form">
        <form action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST" role="form">

          <input name="id" type="hidden" value="<?=$student->id?>"/>

          <div class="form-group">
            <label for="firstName">Имя</label>
            <input class="form-control" name="firstName" type="text" maxlength="200" value="<?=htmlspecialchars($student->firstName)?>"/>
          </div>

          <div class="form-group">
            <label for="lastName">Фамилия</label>
            <input class="form-control" name="lastName" type="text" maxlength="200" value="<?=htmlspecialchars($student->lastName)?>"/>
          </div>
          
          <div class="form-group">
            <label for="group">Группа</label>
            <input class="form-control" name="group" type="text" value="<?=htmlspecialchars($student->group)?>"/>
          </div>

          <div class="form-group">
            <label for="mark">Баллы</label>
            <input class="form-control" name="mark" type="number" min="0" max="300" value="<?=$student->mark?>"/>
          </div>

          <div class="form-group">
            <label for="">Пол</label>
            <div class="radio">
              <label><input name="gender" type="radio" value="male"/>М</label>
            </div>
            <div class="radio">
              <label><input name="gender" type="radio" value="female"/>Ж</label>
            </div>
          </div>

          <div class="form-group">
            <label for="birthyear">Год рождения</label>
            <input class="form-control" name="birthyear" type="number" min="1900" max="2000" value="<?=$student->birthyear?>"/>
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" name="email" type="email" maxlength="254" value="<?=htmlspecialchars($student->email)?>"/>
          </div>

          <button class="btn btn-default" type="submit">Сохранить</button>
        </form>
      </div>
    </div>
  </body>
</html>
