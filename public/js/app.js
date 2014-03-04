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
        var storage_action_error_handling;
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
        scope.getPage = function(page_requested) {
          var qGetResp;
          if (page_requested == null) {
            page_requested = 1;
          }
          scope.loading = true;
          qGetResp = $http.get("/api/" + scope.storage + "?page=" + page_requested);
          qGetResp.success(function(data) {
            scope.total_in_view = data.data.length;
            scope.list = data.data;
            scope.total = data.metadata.total;
            scope.current_page = data.metadata.page + 1;
            scope.nb_pages = data.metadata.nb_pages || 1;
            return scope.loading = false;
          });
          return qGetResp.error(function(resp, status) {
            if (status === 403) {
              scope.loading = false;
              return scope.limit_reached = true;
            }
          });
        };
        scope.previous = function() {
          if (scope.current_page === 1) {
            console.log("Can't go on previous page, current is first page");
            return;
          }
          return scope.getPage(scope.current_page - 1);
        };
        scope.next = function() {
          if (scope.current_page === scope.nb_pages) {
            console.log("Can't go on next page, current is last page");
            return;
          }
          scope.getPage(scope.current_page + 1);
          return console.log("next page for " + scope.storage);
        };
        scope.addColor = function(color) {
          var q;
          q = $http.post("/api/" + scope.storage, {
            code: color
          });
          q.success(function(data) {
            console.log("Color " + color + " added successfuly");
            scope.list.unshift(color);
            $("input[type=text]").val("");
            scope.total_in_view++;
            scope.total++;
            return console.log("total in view = " + scope.total_in_view + " / total = " + scope.total);
          });
          return q.error(storage_action_error_handling);
        };
        scope.removeColor = function(color) {
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
              scope.list = _.without(scope.list, _.findWhere(scope.list, color));
              scope.total_in_view--;
              scope.total--;
              if (scope.total_in_view === 0) {
                return scope.getPage();
              }
            });
            return q.error(storage_action_error_handling);
          }
        };
        return scope.getPage();
      }
    };
  }
]);

app.controller('StorageCtrl', [
  '$scope', '$http', function($http, $scope) {
    return console.log("Welcome on larabooster");
  }
]);
