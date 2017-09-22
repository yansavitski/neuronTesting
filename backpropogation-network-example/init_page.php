<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 22.09.2017
 * Time: 19:11
 */

?>

<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <script src="/js/knockout-3.4.2.js"></script>
    </head>
    <body>
        The name is <span data-bind="text: personName"></span>
        <script>
            var myViewModel = {
                personName: ko.observable('Bob'),
                personAge: 123
            };
            ko.applyBindings(myViewModel);
        </script>
    </body>
</html>
