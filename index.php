<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Операции с массивами</title>
  </head>
  <body>
    <main>
      <table>
        <caption class = "tableCaption">Данные о пользователях</caption>
        <tr class = tableHead>
          <th>ФИО</th>
          <th>ФИО по частям</th>
          <th>Склеенное ФИО</th>
          <th>ФИО кратко</th>
          <th>Пол</th>
        </tr>
        <?php 
          $example_persons_array = [
            [
                'fullname' => 'Иванов Иван Иванович',
                'job' => 'tester',
            ],
            [
                'fullname' => 'Степанова Наталья Степановна',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Пащенко Владимир Александрович',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Громов Александр Иванович',
                'job' => 'fullstack-developer',
            ],
            [
                'fullname' => 'Славин Семён Сергеевич',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Цой Владимир Антонович',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Быстрая Юлия Сергеевна',
                'job' => 'PR-manager',
            ],
            [
                'fullname' => 'Шматко Антонина Сергеевна',
                'job' => 'HR-manager',
            ],
            [
                'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Бардо Жаклин Фёдоровна',
                'job' => 'android-developer',
            ],
            [
                'fullname' => 'Шварцнегер Арнольд Густавович',
                'job' => 'babysitter',
            ],
          ];
          // Массив партнеров для подбора идеальной пары
          $partners = [
            ['fullname' => 'ИванОВ', 'name' => 'ИвАн', 'patronomyc' => 'иваНОВич'],
            ['fullname' => 'калистРАтова', 'name' => 'Нина', 'patronomyc' => 'ФЕДоровнА'],
            ['fullname' => 'Сергеев', 'name' => 'аНДРЕЙ', 'patronomyc' => 'ромаНОВич'],
            ['fullname' => 'Панина', 'name' => 'мариЯ', 'patronomyc' => 'ИГОРЕВНА'],
            ['fullname' => 'кузьмичЁв', 'name' => 'юрий', 'patronomyc' => 'алексеевич'],
            ['fullname' => 'занкоВА', 'name' => 'ОЛЬГА', 'patronomyc' => 'АндрееВнА'],
            ['fullname' => 'Абдурахмани', 'name' => 'рашид', 'patronomyc' => 'ибн-Хаттаб'],
            ['fullname' => 'ВиндЗоР', 'name' => 'ЭЛИЗАБЕТ', 'patronomyc' => 'карЛОВна'],
         ];              

         // Функция разделения ФИО на отдельные части: фамилию, имя, отчество
          function getPartsFromFullname($fullName) {
            $parts = explode(" ", $fullName);
            return array_combine(['surname', 'name', 'patronomyc'], $parts);
          }

          // Функция получения ФИО из отдельных частей: фамилии, имени, отчества
          function getFullnameFromParts($surName, $name, $patronomyc) {
            return $surName." ".$name." ".$patronomyc;
          }

          // Функция получения краткой формы ФИО
          function getShortName($fullName) {
            $curPartsName = getPartsFromFullname($fullName); 
            return $curPartsName['name']." ".mb_substr($curPartsName['surname'], 0, 1).".";
          }
    
          // Функция определения пола по имени
          function getGenderFromName($fullName) {
              $curFullName = getPartsFromFullname($fullName); 
              $sumGenderFlag = 0;
              if (mb_substr($curFullName['patronomyc'], -3) === 'вна') {
                  $sumGenderFlag--;
              } elseif (mb_substr($curFullName['patronomyc'], -2) === 'ич') {
                  $sumGenderFlag++;
              }
              if (mb_substr($curFullName['name'], -1) === 'а') {
                $sumGenderFlag--;
              } elseif (mb_substr($curFullName['name'], -1) === 'й' || mb_substr($curFullName['name'], -1) === 'н') {
                  $sumGenderFlag++;
              }
              if (mb_substr($curFullName['surname'], -2) === 'ва') {
                $sumGenderFlag--;
              } elseif (mb_substr($curFullName['surname'], -1) === 'в') {
                $sumGenderFlag++;
              }
              return ($sumGenderFlag <=> 0);
            }
      
          // Функция определения полового состава
          function getGenderDescription($nameGend) {
            $gend = array_column($nameGend, 'gender');
            $arrayMale = array_filter($gend, function($gender) {
              return $gender === "М";
            });
            $arrayFemale = array_filter($gend, function($gender) {
              return $gender === "Ж";
            });
            $countMale = count($arrayMale);
            $countFemale = count($arrayFemale);
            $countUndef = count($gend) - $countMale - $countFemale;
         ?>
            <div class = "shadowbox">
            <a>Гендерный состав аудитории:<br></a>
            <a>-----------------------------------------<br></a>
        <?php
            print "Мужчины - ".number_format($countMale * 100 / count($gend), 1)."%<br>";
            print "Женщины - ".number_format($countFemale * 100 / count($gend), 1)."%<br>";
            print "Не удалось определить - ".number_format($countUndef * 100 / count($gend), 1)."%<br>";
        ?>
            </div>
        <?php
            return;
          }

          // Функция представления элемента ФИО в правильном регистре (1-я буква - заглавная, остальные - строчные)
          function regFullName($name) {
            return mb_strtoupper(mb_substr($name, 0, 1)).mb_strtolower(mb_substr($name, 1));
          }

          // Функция поиска идеальной пары
          function  getPerfectPartner($curSurname, $curName, $curPatronomyc, $arrayCustoms) {
            // Приводим ФИО к правильному регистру
            $curSurname = regFullName($curSurname);
            $curName = regFullName($curName);
            $curPatronomyc = regFullName($curPatronomyc);
            $curFullName = getFullnameFromParts($curSurname, $curName, $curPatronomyc);
            switch (getGenderFromName($curFullName)) {
              case 1:  
                $curGender = "М";
                break;
              case -1:
                $curGender = "Ж";
                break;
            }   
            // ищем случайного пользователя с полом, противоположным полу выбранного партнера
            do {
              $curKey = random_int(0, count($arrayCustoms) - 1);
            }  while (($arrayCustoms[$curKey]['gender'] === $curGender) || ($arrayCustoms[$curKey]['gender'] === "-"));
            $shortName1 = getShortName($curFullName);
            $shortName2 = getShortName($arrayCustoms[$curKey]['fullname']);
            $randomPersent = random_int(1, 10000) / 100;
        ?>
            <br>
            <div class="shadowbox">
        <?php
            print "{$shortName1} + {$shortName2} = <br>";
            print "♡ Идеально на {$randomPersent}% ♡";
        ?>
            </div>
        <?php
            return;
          }
        
          // Формирование и вывод таблицы с разными формами ФИО пользователей
          // для демонстрации работы созданных функций
          for ($i = 0; $i < count($example_persons_array); $i++) {
            $curStr = getPartsFromFullname($example_persons_array[$i]['fullname']); 
            $curFio = getFullnameFromParts($curStr['surname'], $curStr['name'], $curStr['patronomyc']);
            $shortName = getShortName($example_persons_array[$i]['fullname']);
            switch (getGenderFromName($example_persons_array[$i]['fullname'])) {
              case 0:
                  $curGender = "Не определен";
                  break;
              case 1:
                  $curGender = "М";
                  break;
              case -1:
                  $curGender = "Ж";
                  break;
            }
            echo "<tr><td class = \"tableHead\">{$example_persons_array[$i]['fullname']}</td>";
            echo "<td>  {$curStr['surname']}  |  {$curStr['name']}  |  {$curStr['patronomyc']}  </td>";
            echo "<td>$curFio</td>";
            echo "<td>$shortName</td>";
            echo "<td>$curGender</td>";
            echo "</tr>";
          }  
        ?>
          </table>
          <br>
        <?php
         // Формирование массива, содержащего полное имя и признак пола каждого пользователя
          $fullNameGender = [
            ['fullname' => " ", 'gender' => " ",],
          ];
          for ($i = 0; $i < count($example_persons_array); $i++) { 
            $fullNameGender[$i]['fullname'] = $example_persons_array[$i]['fullname']; 
            switch (getGenderFromName($example_persons_array[$i]['fullname'])) {
              case 0:
                $fullNameGender[$i]['gender'] = "-";
                break;
              case 1:
                $fullNameGender[$i]['gender'] = "М";
                break;
              case -1:
                $fullNameGender[$i]['gender'] = "Ж";
                break;
            }
          }

          // Расчет и вывод итогов по половому составу
          getGenderDescription($fullNameGender); 

          // подбор идеальной пары
          do {
            // выбираем случайного человека из массива партнеров, у которого можно явно определить пол
            $i = random_int(0, count($partners) - 1);
            // Приводим ФИО к правильному регистру
            $partners[$i]['fullname'] = regFullName($partners[$i]['fullname']);
            $partners[$i]['name'] = regFullName($partners[$i]['name']);
            $partners[$i]['patronomyc'] = regFullName($partners[$i]['patronomyc']);
            $curGender = getGenderFromName(getFullnameFromParts($partners[$i]['fullname'], $partners[$i]['name'],
               $partners[$i]['patronomyc']));
          } while ($curGender === 0);
          getPerfectPartner($partners[$i]['fullname'], $partners[$i]['name'], 
            $partners[$i]['patronomyc'], $fullNameGender);
      ?>
      <footer>
        <br>
        <br>
        <br>
        <div class="copyright">Copyright @ PetrenkoE</div>   
      </footer>
    </main>
  </body>
</html>


