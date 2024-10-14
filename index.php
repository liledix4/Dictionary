<?php
$CSVLangList = array_map('str_getcsv', file('lang-list.csv'));
function LangList
  (string $PostParam)
  {
  global $CSVLangList;
  $PostParamInt = 0;
  if (isset($_POST[$PostParam]))
    {
    $PostParamInt = intval($_POST[$PostParam]);
    }
  foreach ($CSVLangList[0] as $key => $value)
    {
    $LangReturnString = '';
    if ($key === $PostParamInt)
      {$LangReturnString = ' selected';}
    echo "<option value=\"{$key}\"{$LangReturnString}>{$value}</option>";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Translator</title>
  <style>
    * {box-sizing: border-box;}
    body {
      font-size: 125%;
      color: white;
      background-color: #111;
      max-width: 600px;
      margin: 50px auto;
      font-family: 'Exo 2', 'Segoe UI';
      }
    textarea, select, input {
      background-color: #333;
      color: inherit;
      border: none;
      font-family: inherit;
      font-size: inherit;
      padding: 10px;
      outline: none;
      width: 100%;
      transition: background .2s, color .2s;
      }
      select, input {text-align: center;}
    textarea
      {
      display: block;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      min-width: 100%;
      max-width: 100%;
      padding: 20px;
      margin-bottom: 5px;
      font-size: 150%;
      }
    select[name='lang-orig'] {
      border-bottom-left-radius: 20px;
      }
    input[type='submit'] {
      border-bottom-right-radius: 20px;
      }
    select:hover, input:hover {background-color: rgb(0, 100, 200);}
    select:active, input:active {background-color: orange;}
    .controls
      {
      display: flex;
      gap: 5px;
      }
    .result
      {
      font-size: 200%;
      margin-top: 20px;
      }
    </style>
</head>
<body>

<form method="post">
  <textarea name="text" rows="5"><?=$_POST['text'];?></textarea>
  <div class="controls">
    <select name="lang-orig">
      <?=LangList('lang-orig');?>
      </select>
    <select name="lang-result">
      <?=LangList('lang-result');?>
      </select>
    <input type="submit" value="Translate">
    </div>
  </form>

<div class="result">
<?php
$CSV = array_map('str_getcsv', file('dictionary.csv'));
if (isset($_POST['text']))
  {
  function ReturnResult
    (string $RequestedString)
    {
    global $CSV;
    foreach ($CSV as $key => $value)
      {
      foreach ($CSV[$key] as $key2 => $value2)
        {
        if ($RequestedString == $CSV[$key][$_POST['lang-orig']])
          {
          return $CSV[$key][$_POST['lang-result']].' ';
          }
        }
      }
    }
  $TextArray = explode(' ',$_POST['text']);
  foreach ($TextArray as $value)
    {
    echo ReturnResult($value);
    }
  }
?>
</div>

</body>
</html>