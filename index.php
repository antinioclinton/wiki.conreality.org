<?php
require_once '.php/Parsedown.php';

if ($_SERVER['REQUEST_URI'] == '/') {
  $host = $_SERVER['HTTP_HOST'];
  header("Location: http://$host/Home", true, 302);
  return;
}

class Parser extends Parsedown {}

function expand_wikilinks($text) {
  return preg_replace_callback(
    '|(\[\[[^\]]+\]\])|',
    function ($matches) {
      $page = substr($matches[1], 2, -2);
      if (strpos($page, '|') !== FALSE) {
        list($page, $link) = explode('|', $page);
        $link = str_replace(' ', '-', $link);
      }
      else {
        $link = str_replace(' ', '-', $page);
      }
      $link = str_replace('/', '-', $link);
      return "[$page](/$link)";
    },
    $text);
}

function render_markdown($input) {
  static $parser = null;
  if (!$parser) {
    $parser = new Parser();
    $parser->setMarkupEscaped(true);
  }
  $output = expand_wikilinks($input);
  $output = $parser->text($output);
  return $output;
}

$sidebar = render_markdown(file_get_contents('_Sidebar.md'));
$footer  = render_markdown(file_get_contents('_Footer.md'));

if (preg_match('|/([0-9A-Za-z&-]+)|', $_SERVER['REQUEST_URI'], $matches) &&
    file_exists($matches[1] . '.md')) {
  $link = $matches[1];
  $content = render_markdown(file_get_contents($link . '.md'));
  if ($link != 'Home') {
    $page = str_replace('-', ' ', $link);
    $content = "<h1>$page</h1>\n\n" . $content;
  }
}
else {
  $content = '<h1>404 Not Found</h1>';
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Conreality wiki</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cosmo/bootstrap.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="/index.css"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body role="document">
    <nav id="navbar" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse"> FIXME
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Conreality wiki</a>
          <span class="navbar-text navbar-version pull-left"><b><?php echo gmdate('Y-m-d') ?></b></span>
        </div>
        <div class="collapse navbar-collapse nav-collapse">
          <ul class="nav navbar-nav">
          </ul>
          <form class="navbar-form navbar-right">
            <button id="edit" type="button" class="btn btn-primary">Edit</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-md-9 content">
          <div class="section">
            <?php echo $content ?>
          </div>
        </div>
        <div class="col-md-3 sidebar">
          <div class="panel panel-default">
            <div class="panel-body">
               <?php echo $sidebar ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <p class="pull-right">
          <a href="#">Back to top</a><br/>
        </p>
        <?php echo $footer ?>
      </div>
    </footer>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="/index.js"></script>
  </body>
</html>