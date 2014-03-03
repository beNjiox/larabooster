var app;

app = angular.module('app', []).config(function($interpolateProvider) {
  return $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

app.filter('upper', function() {
  return function(data) {
    return data.toUpperCase();
  };
});

app.directive('storagePanel', [
  '$http', '$timeout', function($http, $timeout) {
    return {
      restrict: 'E',
      templateUrl: "partials/storage_panel.html",
      scope: {
        'storage': '@ngName'
      },
      link: function(scope, element, attrs) {
        var qGetResp, storage_action_error_handling;
        storage_action_error_handling = function(resp, status) {
          if (status === 403) {
            alert(resp);
            return scope.limit_reached = true;
          } else {
            return alert("An error occured [" + resp.msg + "]");
          }
        };
        $timeout(function() {
          return jQuery("#" + scope.storage + " input[type=text]").mask("#hhhhhh");
        }, 100);
        scope.loading = true;
        scope.list = [];
        scope.name = scope.storage;
        scope.limit_reached = false;
        qGetResp = $http.get("/api/" + scope.storage);
        qGetResp.success(function(data) {
          scope.list = data;
          return scope.loading = false;
        });
        qGetResp.error(function(resp, status) {
          if (status === 403) {
            scope.loading = false;
            return scope.limit_reached = true;
          }
        });
        scope.addColor = function(color) {
          var q;
          q = $http.post("/api/" + scope.storage, {
            code: color
          });
          q.success(function(data) {
            console.log("Color " + color + " added successfuly");
            scope.list.unshift(color);
            return $("input[type=text]").val("");
          });
          return q.error(storage_action_error_handling);
        };
        return scope.removeColor = function(color) {
          var q;
          if (confirm("You are attempting to delete " + color + " from " + scope.name + ". Confirm?")) {
            q = $http({
              method: "delete",
              url: "/api/" + scope.storage,
              params: {
                code: color
              }
            });
            q.success(function(data) {
              var id;
              console.log("Color " + color + " removed successfuly");
              id = "" + scope.storage + "_" + color;
              $(id).fadeOut();
              return scope.list = _.without(scope.list, _.findWhere(scope.list, color));
            });
            return q.error(storage_action_error_handling);
          }
        };
      }
    };
  }
]);

app.controller('StorageCtrl', [
  '$scope', '$http', function($http, $scope) {
    return console.log("Welcome on larabooster");
  }
]);
