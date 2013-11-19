<!DOCTYPE html>
<html ng-app="BreakWallApp">
<head>
    <meta charset="utf-8">
    <title>DevFest BreakWall</title>
    <link rel="stylesheet" href="http://quest.devfest.cz/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/angular.min.js"></script>
    <script src="http://quest.devfest.cz/js/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/sortable.js"></script>
    <script src='https://cdn.firebase.com/v0/firebase.js'></script>
    <script src="js/BreakWallCtrl.js"></script>
</head>
<body ng-controller="BreakWallCtrl">
<h2>Snímky</h2>
<form class="form-inline">
    <div ui-sortable="sortableOptions" ng-model="slides">
        <div ng-repeat="slide in slides" class="row">
            <div class="col-xs-1">Snímek {{$index + 1}}</div>
            <div class="form-group col-xs-4">
                <input type="text" class="form-control" placeholder="URL" ng-model="slide.url">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Čas(s)" ng-model="slide.time">
            </div>
            <div class="checkbox">
                <input type="checkbox" ng-model="slide.reload"> Reload
            </div>
            <!--<button class="btn btn-default" ng-click="remove($index)">Smazat</button>-->
        </div>
    </div>
    <h3>Nový snímek</h3>
    <div class="form-group col-xs-4">
        <input type="text" class="form-control" id="url-input" placeholder="URL" ng-model="newSlide.url">
    </div>
    <div class="form-group">
        <input type="number" class="form-control" id="time-input" placeholder="Čas(s)" ng-model="newSlide.time">
    </div>
    <div class="checkbox">
        <input type="checkbox" id="reload-input" ng-model="newSlide.reload"> Reload
    </div>
    <button class="btn btn-default" ng-click="addSlide()">Přidat</button>
</form>

<label>URL pro sdílení: <input class="form-control" value="{{createUrl()}}"></label>
<button class="btn btn-success" ng-disabled="slides.length == 0" ng-click="runSlideshow()">Spustit slideshow</button>
<button class="btn btn-primary" ng-disabled="slides.length == 0" ng-click="savePreset()">Uložit slideshow</button>
<button class="btn btn-danger" ng-disabled="slides.length == 0" ng-click="removeAll()">Smazat snímky</button>

<h3 ng-if="anyPreset()">Uložené slideshow</h3>
<div class="col-md-6">
    <table class="table table-condensed">
        <tbody ng-repeat="(id, preset) in presets">
        <tr><td colspan="5">
                <h4>Slideshow {{$index+1}}
                    <button class="btn btn-sm btn-success" ng-click="usePreset(id)">Použít</button>
                    <button class="btn btn-sm btn-danger" ng-click="deletePreset(id)">Smazat</button>
                </h4>
            </td></tr>
        <tr>
            <th></th>
            <th>URL</th>
            <th>Čas</th>
            <th>Reload</th>
        </tr>
        <tr ng-repeat="slide in preset">
            <td>Snímek&nbsp;{{$index+1}}</td>
            <td>{{slide.url}}</td>
            <td>{{slide.time}} s</td>
            <td>{{slide.reload}}</td>
        </tr>
        </tbody>
    </table>
</div>
<div id="slideshow">
</div>

</body>
</html>