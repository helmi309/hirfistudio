app.controller('UsersCreateCtrl', ['$state', '$scope', 'users', '$timeout', 'SweetAlert', 'toaster', '$uibModal', '$log', '$http', function ($state, $scope, users, $timeout, SweetAlert, toaster, $uibModal, $log) {
    //Init input addForm variable
    //create users
    $scope.process = false;
    $scope.myModel = {};
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
                //your code for submit
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
    $scope.cekorganisasi = function () {
        $scope.myModel.organisasi = null;
        $scope.myModel.organisasi_id = null;
    };
    $scope.clearInput = function () {
        $scope.myModel = {};
        if ($scope.dataUser.level == 1) {
            $scope.cekbatas()
        }
        else {
            $scope.batasinput = 0
        }

    }
    $scope.dturutan = ''
    $scope.openusers = function (id) {

        var modalInstance = $uibModal.open({
            templateUrl: 'assets/src/users/organisasi.dialog.html',
            controller: 'OrganisasiCtrl',
            size: 'lg',
            resolve: {
                id: function () {
                    return id;
                }
            }
        });

        modalInstance.result.then(function (data) {
            // $scope.selected = selectedItem;
            $scope.myModel.organisasi = data.akun
            $scope.myModel.organisasi_id = data.id
        }, function () {
        });
    };

    $scope.cekbatas = function () {
        users.cekbatasinput()
            .success(function (data) {
                $scope.batasinput = data
            })
    }
    if ($scope.dataUser.level == 1) {
        $scope.cekbatas()
    }
    else {
        $scope.batasinput = 0
    }

    $scope.submitData = function (isBack) {
        $scope.alerts = [];
        //Set process status
        $scope.process = true;
        //Close Alert
        //Check validation status
        if ($scope.Form.$valid) {
            //run Ajax
            if ($scope.dataUser.level == 2 || $scope.dataUser.level == 3 || $scope.dataUser.level == 4) {
                $scope.myModel.organisasi_id = $scope.dataUser.organisasi_id
            }
            users.store($scope.myModel)
                .success(function (data) {
                    if (data.created == true) {
                        //If back to list after submitting
                        if (isBack == true) {
                            $state.go('app.users');
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
                        //Clear Input
                    }

                })
                .error(function (data, status) {
                    // unauthorized
                    if (status === 401) {
                        //redirect to login
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
                        text: 'Simpan Data Gagal!'
                    };
                    toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                });
        }
    };

}]);
app.controller('OrganisasiCtrl', ['$state', '$scope', 'users', 'SweetAlert', 'toaster', '$uibModalInstance','id', function ($state, $scope, users, SweetAlert, toaster, $uibModalInstance,id) {

    $scope.myModel = {}

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
    //Set process status to false
    $scope.process = false;

    //Init Alert status
    $scope.alertset = {
        show: 'hide',
        class: 'green',

        msg: ''
    };
    $scope.main = {
        page: 1,
        term: ''
    };
$scope.id =id
    $scope.dataOrganisasi = '';
    // init get data
    users.getorganisasi($scope.main.page, $scope.main.term)
        .success(function (data) {

            //Change Loading status
            $scope.setLoader(false);

            // result data
            $scope.dataOrganisasi = data.data;
            $scope.cobadata = {}
            angular.forEach($scope.dataOrganisasi, function (value, key) {
                $scope.key = key
                users.cekjmlorganisasi(value.id,$scope.id)
                    .success(function (data1) {
                        $scope.setLoader(false);
                        $scope.cobadata[value.id] = data1;
                    })
            });

            // set the current page
            $scope.current_page = data.current_page;

            // set the last page
            $scope.last_page = data.last_page;

            // set the data from
            $scope.from = data.from;

            // set the data until to
            $scope.to = data.to;

            // set the total result data
            $scope.total = data.total;
        })
        .error(function (data, status) {
            // unauthorized
            if (status === 401) {
                //redirect to login
                $scope.redirect();
            }
            console.log(data);
        });

    // get data
    $scope.getData = function () {

        //Start loading
        $scope.setLoader(true);

        users.getorganisasi($scope.main.page, $scope.main.term)
            .success(function (data) {

                //Stop loading
                $scope.setLoader(false);

                // result data
                $scope.dataOrganisasi = data.data;
                $scope.cobadata = {}
                angular.forEach($scope.dataOrganisasi, function (value, key) {
                    $scope.key = key
                    users.cekjmlorganisasi(value.id,$scope.id)
                        .success(function (data1) {
                            $scope.setLoader(false);
                            $scope.cobadata[value.id] = data1;
                        })
                });

                // set the current page
                $scope.current_page = data.current_page;

                // set the last page
                $scope.last_page = data.last_page;

                // set the data from
                $scope.from = data.from;

                // set the data until to
                $scope.to = data.to;

                // set the total result data
                $scope.total = data.total;
            })
            .error(function (data, status) {
                // unauthorized
                if (status === 401) {
                    //redirect to login
                    $scope.redirect();
                }
                console.log(data);
            });
    };

    // Navigasi halaman terakhir
    $scope.lastPage = function () {
        //Disable All Controller
        $scope.main.page = $scope.last_page;
        $scope.getData();
    };

    // Navigasi halaman selanjutnya
    $scope.nextPage = function () {
        // jika page = 1 < halaman terakhir
        if ($scope.main.page < $scope.last_page) {
            // halaman saat ini ditambah increment++
            $scope.main.page++
        }
        // panggil ajax data
        $scope.getData();
    };

    // Navigasi halaman sebelumnya
    $scope.previousPage = function () {
        //Disable All Controller

        // jika page = 1 > 1
        if ($scope.main.page > 1) {
            // page dikurangi decrement --
            $scope.main.page--
        }
        // panggil ajax data
        $scope.getData();
    };

    // Navigasi halaman pertama
    $scope.firstPage = function () {
        //Disable All Controller

        $scope.main.page = 1;

        $scope.getData()
    };


    $scope.setLoader(true);

    //Init input form variable

    //Init Alert status
    $scope.alertset = {
        show: 'hide',
        class: 'green',
        msg: ''
    };

    //Close Dialog
    $scope.pilihdataoraganisasi = function (data) {
        $scope.selected = data;
        $uibModalInstance.close(data);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    }
}]);
