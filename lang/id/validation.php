<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan default yang digunakan oleh
    | kelas validator. Beberapa aturan ini memiliki beberapa versi
    | seperti aturan ukuran. Silakan sesuaikan setiap pesan ini di sini.
    |
    */

    'accepted' => 'Isian :attribute harus diterima.',
    'accepted_if' => 'Isian :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Isian :attribute harus berupa URL yang valid.',
    'after' => 'Isian :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Isian :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Isian :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Isian :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Isian :attribute only boleh berisi huruf dan angka.',
    'any_of' => 'Isian :attribute tidak valid.',
    'array' => 'Isian :attribute harus berupa sebuah array.',
    'ascii' => 'Isian :attribute hanya boleh berisi karakter alfanumerik single-byte dan simbol.',
    'before' => 'Isian :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Isian :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Isian :attribute harus memiliki antara :min dan :max item.',
        'file' => 'Ukuran file :attribute harus antara :min dan :max kilobita.',
        'numeric' => 'Nilai :attribute harus antara :min dan :max.',
        'string' => 'Isian :attribute harus memiliki antara :min dan :max karakter.',
    ],
    'boolean' => 'Isian :attribute harus berupa benar atau salah.',
    'can' => 'Isian :attribute berisi nilai yang tidak sah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => 'Isian :attribute tidak memiliki nilai yang diperlukan.',
    'current_password' => 'Password yang diberikan salah.',
    'date' => 'Isian :attribute harus berupa tanggal yang valid.',
    'date_equals' => 'Isian :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Isian :attribute harus sesuai dengan format :format.',
    'decimal' => 'Isian :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Isian :attribute harus ditolak.',
    'declined_if' => 'Isian :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Isian :attribute dan :other harus berbeda.',
    'digits' => 'Isian :attribute harus :digits digit.',
    'digits_between' => 'Isian :attribute harus antara :min dan :max digit.',
    'dimensions' => 'Isian :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Isian :attribute memiliki nilai duplikat.',
    'doesnt_contain' => 'Isian :attribute tidak boleh berisi salah satu dari berikut: :values.',
    'doesnt_end_with' => 'Isian :attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => 'Isian :attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
    'email' => 'Isian :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Isian :attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'extensions' => 'Isian :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Isian :attribute harus berupa file.',
    'filled' => 'Isian :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Isian :attribute harus memiliki lebih dari :value item.',
        'file' => 'Ukuran file :attribute harus lebih besar dari :value kilobita.',
        'numeric' => 'Nilai :attribute harus lebih besar dari :value.',
        'string' => 'Isian :attribute harus lebih panjang dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Isian :attribute harus memiliki :value item atau lebih.',
        'file' => 'Ukuran file :attribute harus lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => 'Nilai :attribute harus lebih besar dari atau sama dengan :value.',
        'string' => 'Isian :attribute harus lebih panjang dari atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Isian :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Isian :attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => 'Isian :attribute harus ada di dalam :other.',
    'in_array_keys' => 'Isian :attribute harus berisi setidaknya satu dari kunci berikut: :values.',
    'integer' => 'Isian :attribute harus berupa bilangan bulat.',
    'ip' => 'Isian :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Isian :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Isian :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Isian :attribute harus berupa string JSON yang valid.',
    'list' => 'Isian :attribute harus berupa daftar.',
    'lowercase' => 'Isian :attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => 'Isian :attribute harus memiliki kurang dari :value item.',
        'file' => 'Ukuran file :attribute harus kurang dari :value kilobita.',
        'numeric' => 'Nilai :attribute harus kurang dari :value.',
        'string' => 'Isian :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Isian :attribute tidak boleh memiliki lebih dari :value item.',
        'file' => 'Ukuran file :attribute harus kurang dari atau sama dengan :value kilobita.',
        'numeric' => 'Nilai :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Isian :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Isian :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Isian :attribute tidak boleh memiliki lebih dari :max item.',
        'file' => 'Ukuran file :attribute tidak boleh lebih besar dari :max kilobita.',
        'numeric' => 'Nilai :attribute tidak boleh lebih besar dari :max.',
        'string' => 'Isian :attribute tidak boleh lebih panjang dari :max karakter.',
    ],
    'max_digits' => 'Isian :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Isian :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Isian :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'array' => 'Isian :attribute harus memiliki setidaknya :min item.',
        'file' => 'Ukuran file :attribute minimal harus :min kilobita.',
        'numeric' => 'Nilai :attribute minimal harus :min.',
        'string' => 'Isian :attribute minimal harus :min karakter.',
    ],
    'min_digits' => 'Isian :attribute harus memiliki setidaknya :min digit.',
    'missing' => 'Isian :attribute harus hilang.',
    'missing_if' => 'Isian :attribute harus hilang ketika :other adalah :value.',
    'missing_unless' => 'Isian :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Isian :attribute harus hilang ketika :values ada.',
    'missing_with_all' => 'Isian :attribute harus hilang ketika :values ada.',
    'multiple_of' => 'Isian :attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => 'Isian :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Isian :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Isian :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Isian :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Isian :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',
    ],
    'present' => 'Isian :attribute harus ada.',
    'present_if' => 'Isian :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Isian :attribute harus ada kecuali :other adalah :value.',
    'present_with' => 'Isian :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Isian :attribute harus ada ketika :values ada.',
    'prohibited' => 'Isian :attribute dilarang.',
    'prohibited_if' => 'Isian :attribute dilarang ketika :other adalah :value.',
    'prohibited_if_accepted' => 'Isian :attribute dilarang ketika :other diterima.',
    'prohibited_if_declined' => 'Isian :attribute dilarang ketika :other ditolak.',
    'prohibited_unless' => 'Isian :attribute dilarang kecuali :other ada di dalam :values.',
    'prohibits' => 'Isian :attribute melarang :other untuk ada.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => 'Isian :attribute wajib diisi.',
    'required_array_keys' => 'Isian :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Isian :attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => 'Isian :attribute wajib diisi ketika :other diterima.',
    'required_if_declined' => 'Isian :attribute wajib diisi ketika :other ditolak.',
    'required_unless' => 'Isian :attribute wajib diisi kecuali :other ada di dalam :values.',
    'required_with' => 'Isian :attribute wajib diisi ketika :values ada.',
    'required_with_all' => 'Isian :attribute wajib diisi ketika :values ada.',
    'required_without' => 'Isian :attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => 'Isian :attribute wajib diisi ketika tidak ada :values yang ada.',
    'same' => 'Isian :attribute harus sama dengan :other.',
    'size' => [
        'array' => 'Isian :attribute harus berisi :size item.',
        'file' => 'Ukuran file :attribute harus :size kilobita.',
        'numeric' => 'Nilai :attribute harus :size.',
        'string' => 'Isian :attribute harus :size karakter.',
    ],
    'starts_with' => 'Isian :attribute harus diawali dengan salah satu dari berikut: :values.',
    'string' => 'Isian :attribute harus berupa string.',
    'timezone' => 'Isian :attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => 'Isian :attribute harus berupa huruf besar.',
    'url' => 'Isian :attribute harus berupa URL yang valid.',
    'ulid' => 'Isian :attribute harus berupa ULID yang valid.',
    'uuid' => 'Isian :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut menggunakan
    | konvensi "attribute.rule" untuk menamai baris. Ini membuatnya cepat
    | untuk menentukan baris bahasa kustom tertentu untuk aturan atribut tertentu.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar placeholder atribut kita
    | dengan sesuatu yang lebih mudah dibaca seperti "Alamat E-Mail" daripada
    | "email". Ini hanya membantu kita membuat pesan kita lebih ekspresif.
    |
    */

    'attributes' => [
        'nama_lengkap' => 'Nama Lengkap',
        'nip' => 'NIP',
        'email' => 'Alamat Email',
        'password' => 'Password',
        'password_confirmation' => 'Konfirmasi Password',
        'current_password' => 'Password Saat Ini',
        'jabatan' => 'Jabatan',
        'status_kepegawaian' => 'Status Kepegawaian',
        'jenis_kelamin' => 'Jenis Kelamin',
        'penempatan_id' => 'Lokasi Penempatan',
        'role_id' => 'Role',
        'foto' => 'Foto',
        'tanggal' => 'Tanggal',
        'jam_masuk' => 'Jam Masuk',
        'jam_pulang' => 'Jam Pulang',
        'keterangan' => 'Keterangan',
        'file_lampiran' => 'File Lampiran',
        'status_kehadiran' => 'Status Kehadiran',
        'nama_lokasi' => 'Nama Lokasi',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'radius_meter' => 'Radius',
    ],

];