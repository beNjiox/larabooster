app = angular.module('app', []).config ($interpolateProvider) ->
    $interpolateProvider.startSymbol('[[').endSymbol(']]')

# Filters

app.filter 'upper', () ->
    return (data) ->
        data.toUpperCase()

# Directives

app.directive 'storagePanel', ['$http', '$timeout', ($http, $timeout) ->
    return {
        restrict: 'E'
        templateUrl: "partials/storage_panel.html"
        scope:
            'storage': '@ngName'
        link: (scope, element, attrs) ->

            storage_action_error_handling = (resp, status) ->
              if status is 403
                alert resp
                scope.limit_reached = true
              else
                alert "An error occured [#{resp.msg}]"

            # fixme ; doesn't work without time
            $timeout ->
                jQuery("##{scope.storage} input[type=text]").mask("#hhhhhh");
            , 100

            scope.loading       = true
            scope.list          = []
            scope.name          = scope.storage
            scope.limit_reached = false
            qGetResp            = $http.get("/api/#{scope.storage}")

            qGetResp.success (data) ->
                scope.list    = data
                scope.loading = false

            qGetResp.error (resp, status) ->
              if status is 403
                scope.loading       = false
                scope.limit_reached = true

            scope.addColor = (color) ->
                q = $http.post("/api/#{scope.storage}", {code: color})
                q.success (data) ->
                    console.log "Color #{color} added successfuly"
                    scope.list.unshift color
                    $("input[type=text]").val("")
                q.error storage_action_error_handling
            scope.removeColor = (color) ->
                if confirm "You are attempting to delete #{color} from #{scope.name}. Confirm?"
                    q = $http
                        method: "delete"
                        url: "/api/#{scope.storage}"
                        params: {code: color}
                    q.success (data) ->
                        console.log "Color #{color} removed successfuly"
                        id = "#{scope.storage}_#{color}";
                        $(id).fadeOut()
                        scope.list = _.without(scope.list, _.findWhere(scope.list, color))
                    q.error storage_action_error_handling
    }
]

# Controller

app.controller 'StorageCtrl', [ '$scope', '$http', ($http, $scope) ->
    console.log "Welcome on larabooster"
]