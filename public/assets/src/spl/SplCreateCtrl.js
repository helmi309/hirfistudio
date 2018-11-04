app.controller('SplCreateCtrl', ['$state', '$scope', 'spl', '$timeout', 'SweetAlert', 'toaster', '$http', function ($state, $scope, spl, $timeout, SweetAlert, toaster) {
    // Init Input Add Form Variable
    // Create Posts
    $scope.process = false;

    $scope.master = $scope.myModel;
    $scope.form = {

        submit: function (form) {
            var firstError = null;
            if (form.$invalid) {

                var field = null, firstError = null;
                for (field in form) {
                    if (field[0] != '$') {
                        if (firstError === null && !form[field].$valid) {
                            firstError = form[field].$name;
                        }

                        if (form[field].$pristine) {
                            form[field].$dirty = true;
                        }
                    }
                }
                angular.element('.ng-invalid[name=' + firstError + ']').focus();
                SweetAlert.swal("The form cannot be submitted because it contains validation errors!", "Errors are marked with a red, dashed border!", "error");
                return;

            } else {
                SweetAlert.swal("Good job!", "Your form is ready to be submitted!", "success");
                // Your Code For Submit
            }

        },
        reset: function (form) {

            $scope.myModel = angular.copy($scope.master);
            form.$setPristine(true);
        }

    };
    $scope.closeAlert = function (index) {
        $scope.alerts.splice(index, 1);
    };
    $scope.clearInput = function () {
        $scope.myModel.judul = null;
        $scope.myModel.gambar = null;
        $scope.myModel.deskripsi = null;
    };
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
    $scope.submitData = function (isBack) {
        $scope.alerts = [];
        // Set Process Status
        $scope.process = true;
        // Close Alert

        // Check Validation Status
        if ($scope.Form.$valid) {
            // Run Ajax
            $scope.myModel.tanggal2 = $scope.myModel.tanggal
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
            spl.store($scope.myModel)
                .success(function (data) {
                    if (data.created == true) {
                        // If back to list after submitting
                        if (isBack == true) {
                            $state.go('app.spl');
                            $scope.toaster = {
                                type: 'success',
                                title: 'Sukses',
                                text: 'Simpan Data Berhasil!'
                            };
                            toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                        } else {
                            $scope.clearInput();
                            $scope.sup();
                            $scope.alerts.push({
                                type: 'success',
                                msg: 'Simpan Data Berhasil!'
                            });
                            $scope.process = false;
                            $scope.toaster = {
                                type: 'success',
                                title: 'Sukses',
                                text: 'Simpan Data Berhasil!'
                            };
                            toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                        }
                        // Clear Input
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
                    $scope.myModel.tanggal = $scope.myModel.tanggal2
                    $scope.toaster = {
                        type: 'error',
                        title: 'Gagal',
                        text: 'Simpan Data Gagal!'
                    };
                    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                });
        }
    };

}]);
