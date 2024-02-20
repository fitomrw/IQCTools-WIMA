<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Supplier;
use App\Models\kategoriPart;
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

        Part::create([
            'kode_part' => 'D11501',
            'nama_part' => 'Hinge Cushion',
            'gambar_part' => 'D1150120240131055536.PNG',
            'kategori_id' => '2',
            'supplier_id' => '3'
        ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);
        
        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

        // standarMIL::create([
        //     'min_sample' => ''
        //     'max_sample' => ''
        //     'size_code' => ''
        //     'sample_size' => ''
        // ]);

            
        
    }
}
