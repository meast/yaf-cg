<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $e->getMessage() ?></title>
        <style>
            body { background-color: #fff; color: #333;word-break:break-all; }

            body, p, ol, ul, td {
                font-family: verdana, arial, helvetica, sans-serif;
                font-size:   13px;
                line-height: 18px;
                background-color: #fdfdfd;
            }
            h1,h2,h3,h4 {
                color: #000066;
            }
            pre {
                border: 2px solid #ccc; 
                background-color: #eeeeff;
                padding: 10px;
                font-size: 11px;
            }
            span.file { color: #00B;}
            span.line { color: #070;}
            span.exception {text-decoration: underline; color: #dd0000;}
            .strong{ font-weight: bold;}
            a { color: #000099; }
            a:visited { color: #666; }
            a:hover { color: #000099; text-decoration: none; }
        </style>
    </head>
    <body>
<h1><?php echo $e_class ?></h1>
<pre class="strong">
    <span class="exception"><?php echo  $e_class; ?></span>: 
    <span class="message"><?php echo $e->getMessage()?></span> in file 
    <span class="file"><?php echo $e->getFile()?></span> at line <span class="line"><?php echo $e->getLine()?></span>
</pre>

<div id="traces">
    <h2>Exception Trace</h2>
    <pre><code><?php echo $e->getTraceAsString()?></code></pre>
    <h2>Debug Backtrace</h2>
    <pre><code><?php debug_print_backtrace(); ?></code></pre>
</div>
<h2 style="margin-top: 30px;">Request</h2>
<p>
    <b>Parameters: </b>
    <pre><?php print_r($params) ?></pre>
</p>
    </body>
</html>
