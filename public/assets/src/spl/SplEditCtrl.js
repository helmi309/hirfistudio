app.controller('SplEditCtrl', ['$state', '$scope', 'spl', 'SweetAlert', 'toaster', '$stateParams', function ($state, $scope, spl, SweetAlert, toaster, mdToast, $stateParams) {
    $scope.id = $scope.$stateParams.id;
    // Edit Posts
    // If Id s empty, then redirected
    if ($scope.id == null || $scope.id == '') {
        $state.go("app.spl")
    }

    $scope.isLoading = true;
    $scope.isLoaded = false;

    $scope.setLoader = function (status) {
        if (status == true) {
            $scope.isLoading = true;
            $scope.isLoaded = false;
        } else {
            $scope.isLoading = false;
            $scope.isLoaded = true;
        }
    };

    // Init Input Form Variable
    $scope.input = {};

    // Set Process Status To False
    $scope.process = false;

    // Init Alert Status
    $scope.alertset = {
        show: 'hide',
        class: 'green',
        msg: ''
    };

    // Get Lass Posts
    $scope.today = function () {
        $scope.dt = new Date();
    };

    $scope.today();

    $scope.clear = function () {
        $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function (date, mode) {
        return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    };

    $scope.toggleMin = function () {
        $scope.minDate = $scope.minDate ? null : new Date();
    };

    $scope.toggleMin();

    $scope.open = function ($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1,
        class: 'datepicker'
    };

    $scope.initDate = new Date('2016-15-20');
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];

    // Run Ajax
    spl.show($scope.id)
        .success(function (data) {
            $scope.setLoader(false);
            $scope.myModel = data;
            $scope.hari = parseInt($scope.myModel.tanggal.substr(0, 2)) - 1
            $scope.myModel.tanggal = new Date($scope.myModel.tanggal.substr(6, 4) + '-' + $scope.myModel.tanggal.substr(3, 2) + '-' + $scope.hari + 'T17:00:00.000Z')
        });

    $scope.showToast = function (warna, msg) {
        $mdToast.show({
            // controller: 'AkunToastCtrl',
            template: "<md-toast class='" + warna + "-500'><span flex> " + msg + "</span></md-toast> ",
            // templateUrl: 'views/ui/material/toast.tmpl.html',
            hideDelay: 6000,
            parent: '#toast',
            position: 'top right'
        });
    };

    // Submit Data
    $scope.updateData = function () {
    $scope.alerts = [];
        // Set Process Status
        $scope.process = true;

        // Close Alert
        // $scope.alertset.show = 'hide';

        // Check Validation Status
        if ($scope.Form.$valid) {
            // Run Ajax
            if ($scope.myModel.tanggal instanceof Date) {
                //$scope.d = new Date();
                $scope.year = $scope.myModel.tanggal.getFullYear();
                $scope.month = $scope.myModel.tanggal.getMonth() + 1;
                $scope.day = $scope.myModel.tanggal.getDate();
                if ($scope.month < 10) {
                    $scope.month = "0" + $scope.month;
                }
                if ($scope.day < 10) {
                    $scope.day = "0" + $scope.day;
                }
                $scope.myModel.tanggal = $scope.day + "/" + $scope.month + "/" + $scope.year;
            }
      
            spl.update($scope.myModel)
                .success(function (data) {
                    if (data.updated == true) {
                        // If back to list after submitting
                        // Redirect to akun
                        $state.go('app.spl');
                        $scope.toaster = {
                            type: 'success',
                            title: 'Sukses',
                            text: 'Update Data Berhasil!'
                        };
                        toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                    }
                })
                .error(function (data, status) {
                    // Unauthorized
                    if (status === 401) {
                        // Redirect To Login
                        $scope.redirect();
                    }
                    $scope.sup();
                    // Stop Loading
                    $scope.process = false;
                    $scope.alerts.push({
                        type: 'danger',
                        msg: data.validation
                    });
                    $scope.toaster = {
                        type: 'error',
                        title: 'Gagal',
                        text: 'Update Data Gagal!'
                    };
                    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                });
        }
    };

}]);
