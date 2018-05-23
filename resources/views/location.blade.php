<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		h3 img {
    max-height: 50px;
}
#map { 
    height: 400px;
    margin: 20px 0;
    border-radius: 5px;
    border: 1px solid silver;
}
	</style>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container" ng-app="myApp" ng-controller="newPlaceCtrl">
    
    <h3 class="clearfix">
        <img class="pull-left" src="http://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/AngularJS_logo.svg/695px-AngularJS_logo.svg.png"/>
        <img class="pull-right" src="http://upload.wikimedia.org/wikipedia/commons/9/9a/Google_maps_logo.png"/>
    </h3>
    
    <div class="alert alert-danger text-center" role="alert" ng-show="apiError">
        <b>API Error : </b>
        <span>{{ apiStatus }}</span>
    </div>
    
    <form name="searchForm" novalidate 
    ng-submit="search()">
        <div class="input-group">
            <input name="place" type="text" class="form-control" 
            ng-model="searchPlace" required autofocus />
            <span class="input-group-btn">
                <button class="btn btn-primary" 
                ng-disabled="searchForm.$invalid">Search</button>
            </span>
        </div>
    </form>
        
    <div id="map"></div>
      
    <form name="resForm" class="form-horizontal" novalidate 
    ng-submit="send()">
        <div class="form-group">
            <label for="resName" class="col-xs-2 control-label">Name</label>
            <div class="col-xs-10">
                <input name="resName" type="text" class="form-control" 
                ng-model="place.name" required />
            </div>
        </div>
        <div class="form-group">
            <label for="resLat" class="col-xs-2 control-label">Latitude</label>
            <div class="col-xs-10">
                <input name="resLat" type="number" class="form-control" 
                ng-model="place.lat" required />
            </div>
        </div>
        <div class="form-group">
            <label for="resLng" class="col-xs-2 control-label">Longitude</label>
            <div class="col-xs-10">
                <input name="resLng" type="number" class="form-control" 
                ng-model="place.lng" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button class="btn btn-success" 
                ng-disabled="resForm.$invalid">Confirm</button>
            </div>
        </div>
    </form>
    
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd1xMYT1bt99qtFWQEzXiRBvORDWHgPtk&libraries=places"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.23/angular.min.js"></script>
<script type="text/javascript">
	var app = angular.module('myApp', []);

app.service('Map', function($q) {
    
    this.init = function() {
        var options = {
            center: new google.maps.LatLng(40.7127837, -74.00594130000002),
            zoom: 13,
            disableDefaultUI: true    
        }
        this.map = new google.maps.Map(
            document.getElementById("map"), options
        );
        this.places = new google.maps.places.PlacesService(this.map);
    }
    
    this.search = function(str) {
        var d = $q.defer();
        this.places.textSearch({query: str}, function(results, status) {
            if (status == 'OK') {
                d.resolve(results[0]);
            }
            else d.reject(status);
        });
        return d.promise;
    }
    
    this.addMarker = function(res) {
        if(this.marker) this.marker.setMap(null);
        this.marker = new google.maps.Marker({
            map: this.map,
            position: res.geometry.location,
            animation: google.maps.Animation.DROP
        });
        this.map.setCenter(res.geometry.location);
    }
    
});

app.controller('newPlaceCtrl', function($scope, Map) {
    
    $scope.place = {};
    
    $scope.search = function() {
        $scope.apiError = false;
        Map.search($scope.searchPlace)
        .then(
            function(res) { // success
                Map.addMarker(res);
                $scope.place.name = res.name;
                $scope.place.lat = res.geometry.location.lat();
                $scope.place.lng = res.geometry.location.lng();
            },
            function(status) { // error
                $scope.apiError = true;
                $scope.apiStatus = status;
            }
        );
    }
    
    $scope.send = function() {
        alert($scope.place.name + ' : ' + $scope.place.lat + ', ' + $scope.place.lng);    
    }
    
    Map.init();
});

</script>
</body>
</html>
