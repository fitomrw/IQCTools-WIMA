<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Supplier;
use App\Models\kategoriPart;
use App\Models\StandarModel;
use App\Models\Part;
use App\Models\standarMIL;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        User::create([
            'name' => 'Admin QC',
            'username' => 'adminqc',
            'jabatan' => 'Admin QC',
            'email' => 'adminqc@gmail.com',
            'password' => Hash::make('adminqc')
        ]);

        User::create([
            'name' => 'Staff QC',
            'username' => 'staffqc',
            'jabatan' => 'Staff QC',
            'email' => 'staffqc@gmail.com',
            'password' => Hash::make('staffqc')
        ]);
        
        User::create([
            'name' => 'Kepala Seksi QC',
            'username' => 'kepalaseksiqc',
            'jabatan' => 'Kepala Seksi QC',
            'email' => 'kepalaseksiqc@gmail.com',
            'password' => Hash::make('kepalaseksiqc')
        ]);

        User::create([
            'name' => 'Staff QA',
            'username' => 'staffqa',
            'jabatan' => 'Staff QA',
            'email' => 'staffqa@gmail.com',
            'password' => Hash::make('staffqa')
        ]);

        User::create([
            'name' => 'Muhammad Khurais',
            'username' => 'khurais',
            'jabatan' => 'Admin QC',
            'email' => 'khuraismuhammad@gmail.com',
            'password' => Hash::make('khurais')
        ]);

        User::create([
            'name' => 'Herry Setiawan',
            'username' => 'herry',
            'jabatan' => 'Staff QC',
            'email' => 'herry.setiawan@gmail.com',
            'password' => Hash::make('herry')
        ]);

        User::create([
            'name' => 'Agus Sopandi',
            'username' => 'agussopandi',
            'jabatan' => 'Kepala Seksi QC',
            'email' => 'agussopandi@gmail.com',
            'password' => Hash::make('agussopandi')
        ]);

        User::create([
            'name' => 'Eriyan Dwi Putra',
            'username' => 'eriyan',
            'jabatan' => 'Staff QA',
            'email' => 'eriyandp@gmail.com',
            'password' => Hash::make('eriyan')
        ]);
        
        Supplier::create([
            'nama_supplier' => 'Artomoro Precision',
            'no_telepon' => '(021) 89840336',
            'email' => 'amp@artomoro.com',
            'alamat' => 'Jalan Jababeka 17 D, Blok U 31 E, Cikarang, Jababeka Industrial Estate 1,, 17530, Karangbaru, Cikarang Utara, Karangbaru, Kec. Cikarang Utara, Kabupaten Bekasi, Jawa Barat 17530',
        ]);

        Supplier::create([
            'nama_supplier' => 'Gematic Motor Co.,Ltd',
            'no_telepon' => '089458735671',
            'email' => 'gematic@gmail.com',
            'alamat' => 'No. 58 Lixin Road, Zonghan Industrial Zone, Cixi, Ningbo, Zhejiang, China',
        ]);

        Supplier::create([
            'nama_supplier' => 'Meiwa Indonesia',
            'no_telepon' => '(021) 8741572',
            'email' => 'marketing@meiwa.com',
            'alamat' => 'Jl. Raya Jakarta - Bogor KM 30, Desa/Kelurahan Tugu, Kec. Cimanggis, Kota Depok, Prov. Jawa Barat',
        ]);

        Supplier::create([
            'nama_supplier' => 'Wika Industri dan Konstruksi',
            'no_telepon' => '(021) 22113122',
            'email' => 'info@wikaikon.co.id',
            'alamat' => 'Komplek Industri WIKA, Jl. Raya Narogong, Cileungsi, Kec. Cileungsi, Kabupaten Bogor, Jawa Barat 16820',
        ]);

        Supplier::create([
            'nama_supplier' => 'Nikko Cahaya Electric',
            'no_telepon' => '(021) 89840336',
            'email' => 'marketing@nikko.com',
            'alamat' => 'Tangerang',
        ]);

        Supplier::create([
            'nama_supplier' => 'Nandya Karya Perkasa',
            'no_telepon' => '021 82499447',
            'email' => 'marketing@nandya-karya-perkasa.com',
            'alamat' => 'Jl. KH Umar Kp. Rawailat RT/RW. 003/009, Dayeuh, Kec. Cileungsi, Kab. Bogor, Jawa Barat 16820 - Indonesia',
        ]);

        Supplier::create([
            'nama_supplier' => 'Mitsuba',
            'no_telepon' => '021 5908020',
            'email' => 'marketing@mitsuba.com',
            'alamat' => 'Jl. Prabu Siliwangi No.88, RT.001/RW.004, Keroncong, Kec. Jatiuwung, Kota Tangerang, Banten 15134',
        ]);

        kategoriPart::create([
            'nama_kategori' => 'Plastic Part'
        ]);

        kategoriPart::create([
            'nama_kategori' => 'General'
        ]);

        kategoriPart::create([
            'nama_kategori' => 'Electrical'
        ]);

        kategoriPart::create([
            'nama_kategori' => 'Chassis'
        ]);

        kategoriPart::create([
            'nama_kategori' => 'Bolt & Nut'
        ]);

        StandarModel::create([
            'jenis_standar' => 'VISUAL',
            'alat' => 'VISUAL/MATA',
            'uraian' => 'Permukaan Produk'
        ]);

        StandarModel::create([
            'jenis_standar' => 'VISUAL',
            'alat' => 'VISUAL/MATA',
            'uraian' => 'Cacat'
        ]);

        StandarModel::create([
            'jenis_standar' => 'FUNCTION',
            'alat' => 'SOUND LEVEL METER',
            'uraian' => 'Sound Level at 2 Meter'
        ]);

        StandarModel::create([
            'jenis_standar' => 'FUNCTION',
            'alat' => 'CHECKER DAN TELINGA',
            'uraian' => 'Kualitas Suara'
        ]);

        StandarModel::create([
            'jenis_standar' => 'DIMENSI',
            'alat' => 'CALIPER',
            'uraian' => 'Lebar'
        ]);

        StandarModel::create([
            'jenis_standar' => 'DIMENSI',
            'alat' => 'CALIPER',
            'uraian' => 'Thickness'
        ]);

        StandarModel::create([
            'jenis_standar' => 'DIMENSI',
            'alat' => 'CALIPER',
            'uraian' => 'Diameter'
        ]);

        StandarModel::create([
            'jenis_standar' => 'FUNCTION',
            'alat' => 'TANGAN',
            'uraian' => 'Button Footrest'
        ]);
        
        
    }
}
