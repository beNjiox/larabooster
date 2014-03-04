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

            scope.getPage = (page_requested = 1) ->
              scope.loading = true
              qGetResp      = $http.get("/api/#{scope.storage}?page=#{page_requested}")

              qGetResp.success (data) ->
                  scope.total_in_view = data.data.length
                  scope.list          = data.data
                  scope.total         = data.metadata.total
                  scope.current_page  = data.metadata.page + 1
                  scope.nb_pages      = data.metadata.nb_pages || 1
                  scope.loading       = false

              qGetResp.error (resp, status) ->
                if status is 403
                  scope.loading       = false
                  scope.limit_reached = true

            scope.previous = ->
              if scope.current_page == 1
                console.log "Can't go on previous page, current is first page"
                return ;
              scope.getPage(scope.current_page - 1)

            scope.next = ->
              if scope.current_page == scope.nb_pages
                console.log "Can't go on next page, current is last page"
                return ;
              scope.getPage(scope.current_page + 1)
              console.log "next page for #{scope.storage}"

            scope.addColor = (color) ->
                q = $http.post("/api/#{scope.storage}", {code: color})
                q.success (data) ->
                    console.log "Color #{color} added successfuly"
                    scope.list.unshift color
                    $("input[type=text]").val("")
                    scope.total_in_view++
                    scope.total++
                    console.log "total in view = #{scope.total_in_view} / total = #{scope.total}"
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
                        scope.total_in_view--
                        scope.total--
                        if scope.total_in_view is 0
                          scope.getPage()
                    q.error storage_action_error_handling

            scope.getPage()

    }
]

# Controller

app.controller 'StorageCtrl', [ '$scope', '$http', ($http, $scope) ->
    console.log "Welcome on larabooster"
]