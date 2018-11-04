app.factory('spl', ['$http', function ($http) {
    return {
        
        // Get data dengan pagination & pencarian data
        get: function (page, term) {
            return $http({
                method: 'get',
                url: '/api/spl?page=' + page + '&term=' + term,
                headers: {'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest'}
            });
        },

        // List data
        getLastspl: function () {
            return $http({
                method: 'get',
                url: '/api/get-last-spl',
            });
        },

        // Create data
        store: function (inputData) {
            return $http({
                method: 'POST',
                url: '/api/spl',
                data: $.param(inputData)
            });
        },

        // Detail data
        show: function (_id) {
            return $http({
                method: 'get',
                url: '/api/spl/' + _id,
            });
        },

        // Hapus data
        destroy: function (_id) {
            return $http({
                method: 'delete',
                url: '/api/spl/' + _id,
            });
        },

        // Update data
        update: function (inputData) {
            return $http({
                method: 'put',
                url: '/api/spl/' + inputData.id,
                data: $.param(inputData)
            });
        },

        // Pengaman data
        kunci: function (_id) {
            return $http({
                method: 'put',
                url: '/api/kunci-spl/' + _id
            });
        },

    }

}]);
