<?php

return [

    "accepted"         => ":attribute harus disetujui.",
    "active_url"       => ":attribute bukan valid URL.",
    "after"            => ":attribute harus berupa tanggal setelah :date.",
    "alpha"            => ":attribute hanya boleh berupa kata.",
    "alpha_dash"       => ":attribute hanya boleh berupa kata, nomor, and penghubung.",
    "alpha_num"        => ":attribute hanya boleh berupa kata and nomor.",
    "before"           => ":attribute harus berupa tanggal sebelum :date.",
    "between"          => [
        "numeric" => ":attribute harus di antara :min - :max.",
        "file"    => ":attribute harus di antara :min - :max KB.",
        "string"  => ":attribute harus di antara :min - :max karakter.",
    ],
    "confirmed"        => ":attribute konfirmasi tidak cocok.",
    "date"             => ":attribute bukan tanggal valid.",
    "date_format"      => ":attribute tidak cocok dengan format :format.",
    "different"        => ":attribute dan :other harus berbeda.",
    "digits"           => ":attribute harus berupa :digits digit.",
    "digits_between"   => ":attribute harus di antara :min and :max digit.",
    "email"            => ":attribute bukan berupa valid email.",
    "exists"           => "terpilih :attribute tidak valid.",
    "image"            => ":attribute harus berupa gambar.",
    "in"               => "selected :attribute tidak valid.",
    "integer"          => ":attribute harus berupa angka.",
    "ip"               => ":attribute harus berupa IP address.",
    "max"              => [
        "numeric" => ":attribute tidak boleh lebih dari :max.",
        "file"    => ":attribute tidak boleh lebih dari :max KB.",
        "uploaded"    => ":attribute tidak boleh lebih dari :max KB.",
        "string"  => ":attribute tidak boleh lebih dari :max karakter.",
    ],
    "mimes"            => ":attribute harus berupa file: :values.",
    "uploaded"    => ":attribute tidak boleh lebih dari :max KB.",

    "min"              => [
        "numeric" => ":attribute harus kurang dari :min.",
        "file"    => ":attribute harus kurang dari :min KB.",
        "string"  => ":attribute harus kurang dari :min karakter.",
    ],
    "not_in"           => "selected :attribute tidak valid.",
    "numeric"          => ":attribute harus berupa angka.",
    "regex"            => ":attribute format tidak valid.",
    "required"         => ":attribute harus diisi.",
    "required_with"    => ":attribute harus diisi ketika :values ada.",
    "required_without" => ":attribute harus diisi ketika :values tidak ada.",
    "same"             => ":attribute and :other harus sama.",
    "size"             => [
        "numeric" => ":attribute harus :size.",
        "file"    => ":attribute harus :size KB.",
        "string"  => ":attribute harus :size karakter.",
    ],
    "unique"           => ":attribute sudah ada.",
    "url"              => ":attribute format tidak valid.",
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom'           => [],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes'       => [],

];