/**
 * Created by - LENOVO - on 24/08/2015.
 */
app.factory('users', ['$http', function ($http) {
    return {
        // get data dengan pagination dan pencarian data
        get: function (page, term) {
            return $http({
                method: 'get',
                url: '/api/users?page=' + page + '&term=' + term,
            });
        },
        getorganisasi: function (page, term) {
            return $http({
                method: 'get',
                url: '/api/get-akun-organisasi?page=' + page + '&term=' + term,
            });
        },
        //Simpan data
        store: function (inputData) {
            return $http({
                method: 'POST',
                url: '/api/users',
                data: $.param(inputData)
            });
        },

        //Tampil Data
        show: function (_id) {
            return $http({
                method: 'get',
                url: '/api/users/' + _id,
            });
        },

        destroy: function (_id) {
            return $http({
                method: 'delete',
                url: '/api/users/' + _id,
            });
        },

        //Update data

        
        updatepassword: function (inputData) {
            return $http({
                method: 'put',
                url: 'api/updatePass-users/',
                data: $.param(inputData)
            });
        },

         update: function (inputData) {
            return $http({
                method: 'put',
                url: '/api/users/' + inputData.id,
                data: $.param(inputData)
            });
        },

        aktif: function (_id) {
            return $http({
                method: 'put',
                url: '/api/aktif-user/' + _id
            });
        },
        cekjmlorganisasi: function (_id,_id2) {
            return $http({
                method: 'get',
                url: '/api/cek-jml-organisasi-by-users/' + _id+'/'+_id2,
            });
        },
        cekbatasinput: function () {
            return $http({
                method: 'get',
                url: '/api/batas-input-administrator-user'
            });
        },

    }
}]);