'use strict';

app.controller('UsersCtrl', ['$scope', 'users', 'SweetAlert','$uibModal','$log', '$http','$timeout', function ($scope, users,SweetAlert,$uibModal,$log) {
//urussan tampilan
    $scope.main = {
        page: 1,
        term: ''
    };
  
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
    $scope.users = function (id) {

        var modalInstance = $uibModal.open({
            templateUrl: 'assets/src/users/detail.dialog.html',
            controller: 'Usersdetail2Ctrl',
            size: 'lg',
            resolve: {
                item: function () {
                    return id;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

    //Init Alert status
    $scope.alertset = {
        show: 'hide',
        class: 'green',
        msg: ''
    };
    //refreshData
    $scope.refreshData = function () {
        $scope.main.page = 1;
        $scope.main.term = '';
        $scope.getData();
    };
    // go to print preview page
    $scope.print = function () {
        window.open ('../api/v1/cetak-users','_blank');
    };
    //Init dataAkun
    $scope.dataUsers = '';
    // init get data
    users.get($scope.main.page, $scope.main.term)
        .success(function (data) {

            //Change Loading status
            $scope.setLoader(false);

            // result data
            $scope.dataUsers = data.data;
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

        users.get($scope.main.page, $scope.main.term)
            .success(function (data) {

                //Stop loading
                $scope.setLoader(false);

                // result data
                $scope.dataUsers = data.data;

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
    
    $scope.hapus = function (id) {
        SweetAlert.swal({
            title: "Peringatan?",
            text: "Apakah anda yakin ingin hapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete!",
            cancelButtonText: "Batal!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                users.destroy(id)
                    .success(function (data) {
                        if (data.deleted == true) {
                            SweetAlert.swal({
                                title: "Berhasil!",
                                text: "Data Berhasil Dihapus.",
                                type: "success",
                                confirmButtonColor: "#007AFF"
                            });

                        } else {
                            SweetAlert.swal({
                                title: "Gagal",
                                text: "Data Gagal Dihapus :)",
                                type: "error",
                                confirmButtonColor: "#007AFF"
                            })

                        }
                        $scope.getData();
                    })


            } else {
                SweetAlert.swal({
                    title: "Batal",
                    text: "Data Gagal Dihapus",
                    type: "error",
                    confirmButtonColor: "#007AFF"
                });
            }
        });
    };

    $scope.aktif = function (id) {
        SweetAlert.swal({
            title: "Peringatan?",
            text: "Yakin Aktif Data",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aktif",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                users.aktif(id)
                    .success(function (data) {
                        if (data.updated == true) {
                            SweetAlert.swal({
                                title: "Aktif Data Berhasil!",
                                text: "Berhasil Aktif Data",
                                type: "success",
                                confirmButtonColor: "#007AFF"
                            });

                        } else {
                            SweetAlert.swal({
                                title: "Gagal",
                                text: "Gagal Aktif Data :)",
                                type: "error",
                                confirmButtonColor: "#007AFF"
                            })

                        }
                        $scope.getData();
                    })


            } else {
                SweetAlert.swal({
                    title: "Batal",
                    text: "Batal Aktif Data :)",
                    type: "error",
                    confirmButtonColor: "#007AFF"
                });
            }
        });
    };
    $scope.nonaktif = function (id) {
        SweetAlert.swal({
            title: "Peringatan?",
            text: "Yakin Non AKtif Kunci",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Non AKtif",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                users.aktif(id)
                    .success(function (data) {
                        if (data.updated == true) {
                            SweetAlert.swal({
                                title: "Buka Non AKtif Berhasil!",
                                text: "Buka Non AKtif Data Berhasil",
                                type: "success",
                                confirmButtonColor: "#007AFF"
                            });

                        } else {
                            SweetAlert.swal({
                                title: "Gagal",
                                text: "Buka Non AKtif Data Gagal :)",
                                type: "error",
                                confirmButtonColor: "#007AFF"
                            })

                        }
                        $scope.getData();
                    })


            } else {
                SweetAlert.swal({
                    title: "Batal",
                    text: "Buka Non AKtif Data Batal :)",
                    type: "error",
                    confirmButtonColor: "#007AFF"
                });
            }
        });
    };


}]);

app.controller('Usersdetail2Ctrl', ['$scope', 'users', 'SweetAlert', '$uibModal','$log','$uibModalInstance','toaster','item','$http','$timeout', function ($scope, users,SweetAlert,$uibModal,$log,$uibModalInstance,toaster,item) {
//urussan tampilan
    $scope.myModel ={}
    
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
    $scope.id =item
    users.show($scope.id)
        .success(function (data) {
            $scope.setLoader(false);
            $scope.myModel = data;
        });

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };


}]);