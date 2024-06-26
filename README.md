### Doni Wahyu Kurniawan <br> TI-2H | 13 | 2241720015 <hr>
<div align="center">

# JOBSHEET 3 <br> MIGRATION, SEEDER, DB FACADE, QUERY BUILDER, dan ELOQUENT ORM

</div>

## A. PENGATURAN DATABASE
### Praktikum 1
1. Create Database\
![Create Database](report_asset/js3/1.1.png)
2. Configure .env
    ```
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:g+xSF6FEo9hj5mOa+WWjJbcFfL4nw56yQ3pOVY8rPMc=
    APP_DEBUG=true
    APP_URL=http://localhost

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=PWL_POS
    DB_USERNAME=root
    DB_PASSWORD=
    ```
## B. MIGRATION
### Praktikum 2.1
1. create_m_level_table
    ```php
    public function up(): void
    {
        Schema::create('m_level', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('level_kode', 10)->unique();
            $table->string('level_nama', 100);
            $table->timestamps();
        });
    }
    ```
    php artisan migrate\
    ![create m_level](report_asset/js3/2.1.png)\
    result\
    ![resut m_level](report_asset/js3/2.2.png)
2. create_m_kategori_table
    ```php
    public function up(): void
    {
        Schema::create('m_kategori', function (Blueprint $table) {
            $table->id('kategori_id');
            $table->string('kategori_kode', 10)->unique();
            $table->string('kategori_nama', 100);
            $table->timestamps();
        });
    }
    ```
    php artisan migrate\
    ![create m_level](report_asset/js3/2.3.png)\
    result\
    ![resut m_level](report_asset/js3/2.4.png)
### Praktikum 2.2
1. create m_user_table
    ```php
    Schema::create('m_user', function (Blueprint $table) {
        $table->id('user_id');
        $table->unsignedBigInteger('level_id')->index();
        $table->string('username', 20)->unique();
        $table->string('nama', 100);
        $table->string('password');
        $table->timestamps();

        $table->foreign('level_id')->references('level_id')->on('m_level'); 
    });
    ```
    php artisan migrate\
    ![create m_user](report_asset/js3/2.5.png)\
    result\
    ![result m_user](report_asset/js3/2.6.png)
2. create m_barang
    ```php
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('kategori_id')->index();
            $table->string('barang_kode', 10)->unique();
            $table->string('barang_nama', 100);
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
        });
    }
    ```
3. create t_penjualan
    ```php
        public function up(): void
    {
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('pembeli', 50);
            $table->string('penjualan_kode', 20)->unique();
            $table->dateTime('penjualan_tanggal');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }
    ```
4. create t_stok
    ```php
    public function up(): void
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('barang_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->dateTime('stok_tanggal');
            $table->integer('stok_jumlah');
            $table->timestamps();

            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }
    ```
5. create t_penjualan_detail
    ```php
    public function up(): void
    {
        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('penjualan_id')->index();
            $table->unsignedBigInteger('barang_id')->index();
            $table->integer('harga');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('penjualan_id')->references('penjualan_id')->on('t_penjualan');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
        });
    }
    ```
    php artisan migrate\
    ![migrate all tabel](report_asset/js3/2.7.png)\
    result\
    ![result on database](report_asset/js3/2.8.png)\
    ![result on designer](report_asset/js3/2.9.png)
## C. SEEDER
### Praktikum 3
1. create seeder file for m_level table
    ```
    php artisan make:seeder LevelSeeder
    ```
2. insert the data
    ```php
    use Illuminate\Support\Facades\DB;

    class LevelSeeder extends Seeder
    {
        public function run(): void
        {
            $data = [
                ['level_id' => 1, 'level_kode' => 'ADM', 'level_nama' => 'Administrator'],
                ['level_id' => 2, 'level_kode' => 'MNG', 'level_nama' => 'Manager'],
                ['level_id' => 3, 'level_kode' => 'STF', 'level_nama' => 'Staff/Kasir'],
            ];
            DB::table('m_level')->insert($data);
        }
    }
    ```
    ![run file seeder](report_asset/js3/3.1.png)\
    ![result run levelseeder](report_asset/js3/3.2.png)
3. create seeder file for m_user table that refering to m_level table
    ```
    php artisan make:seeder UserSeeder
    ```
4. modificate UserSeeder class file
    ```php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;

    class UserSeeder extends Seeder
    {
        public function run(): void
        {
            $data = [
                [
                    'user_id' => 1,
                    'level_id' => 1,
                    'username' => 'admin',
                    'nama' => 'Administrator',
                    'password' => Hash::make('12345'),
                ],
                [
                    'user_id' => 2,
                    'level_id' => 2,
                    'username' => 'manager',
                    'nama' => 'Manager',
                    'password' => Hash::make('12345'),
                ],
                [
                    'user_id' => 3,
                    'level_id' => 3,
                    'username' => 'staff',
                    'nama' => 'Staff/Kasir',
                    'password' => Hash::make('12345'),
                ],
            ];
            DB::table('m_user')->insert($data);
        }
    }
    ```
    ![run userSeeder](report_asset/js3/3.3.png)
    ![result userSeeder](report_asset/js3/3.4.png)

5. Insert seeder data for other table
    * m_kategori
        ```php
        public function run(): void
        {
            $data = [
                ['kategori_kode' => 'KTG001', 'kategori_nama' => 'Makanan dan minuman'],
                ['kategori_kode' => 'KTG002', 'kategori_nama' => 'Rumah dan kebutuhan hidup'],
                ['kategori_kode' => 'KTG003', 'kategori_nama' => 'Fashion dan pakaian'],
                ['kategori_kode' => 'KTG004', 'kategori_nama' => 'Olahraga dan kesehatan'],
                ['kategori_kode' => 'KTG005', 'kategori_nama' => 'Elektronik'],
            ];
            DB::table('m_kategori')->insert($data);
        }
        ```
        ![result m_kategori](report_asset/js3/3.5.png)
    * m_barang
        ```php
        public function run(): void
        {
            $data =[
                [
                    'kategori_id' => 1,
                    'barang_kode' => 'BEV001',
                    'barang_nama' => 'Mie instan',
                    'harga_beli' => 3_000,
                    'harga_jual' => 4_000,
                ],
                [
                    'kategori_id' => 1,
                    'barang_kode' => 'BEV002',
                    'barang_nama' => 'Jus jeruk',
                    'harga_beli' => 10_000,
                    'harga_jual' => 15_000,
                ],
                [
                    'kategori_id' => 2,
                    'barang_kode' => 'HOM001',
                    'barang_nama' => 'Rak buku',
                    'harga_beli' => 200_000,
                    'harga_jual' => 250_000,
                ],
                [
                    'kategori_id' => 2,
                    'barang_kode' => 'HOM002',
                    'barang_nama' => 'Tempat sampah',
                    'harga_beli' => 20_000,
                    'harga_jual' => 25_000,
                ],
                [
                    'kategori_id' => 3,
                    'barang_kode' => 'FAS001',
                    'barang_nama' => 'Kaos polos',
                    'harga_beli' => 30_000,
                    'harga_jual' => 40_000,
                ],
                [
                    'kategori_id' => 3,
                    'barang_kode' => 'FAS002',
                    'barang_nama' => 'Jaket kulit',
                    'harga_beli' => 200_000,
                    'harga_jual' => 250_000,
                ],
                [
                    'kategori_id' => 4,
                    'barang_kode' => 'OLR001',
                    'barang_nama' => 'Pull up bar',
                    'harga_beli' => 110_000,
                    'harga_jual' => 150_000,
                ],
                [
                    'kategori_id' => 4,
                    'barang_kode' => 'OLR002',
                    'barang_nama' => 'Whey protein',
                    'harga_beli' => 100_000,
                    'harga_jual' => 130_000,
                ],
                [
                    'kategori_id' => 5,
                    'barang_kode' => 'ELT001',
                    'barang_nama' => 'Kipas angin',
                    'harga_beli' => 100_000,
                    'harga_jual' => 120_000,
                ],
                [
                    'kategori_id' => 5,
                    'barang_kode' => 'ELT002',
                    'barang_nama' => 'Speaker bluetooth',
                    'harga_beli' => 140_000,
                    'harga_jual' => 170_000,
                ]
            ];
            DB::table('m_barang')->insert($data);
        }
        ```
        ![result m_barang](report_asset/js3/3.6.png)
    * t_stok
        ```php
        public function run(): void
        {
            $data = [
                [
                    'barang_id' => 1,
                    'user_id' => 1,
                    'stok_jumlah' => 100,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 2,
                    'user_id' => 2,
                    'stok_jumlah' => 90,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 3,
                    'user_id' => 3,
                    'stok_jumlah' => 110,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 4,
                    'user_id' => 1,
                    'stok_jumlah' => 200,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 5,
                    'user_id' => 2,
                    'stok_jumlah' => 300,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 6,
                    'user_id' => 3,
                    'stok_jumlah' => 60,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 7,
                    'user_id' => 1,
                    'stok_jumlah' => 99,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 8,
                    'user_id' => 2,
                    'stok_jumlah' => 76,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 9,
                    'user_id' => 3,
                    'stok_jumlah' => 80,
                    'stok_tanggal' => Carbon::now()
                ],
                [
                    'barang_id' => 10,
                    'user_id' => 1,
                    'stok_jumlah' => 344,
                    'stok_tanggal' => Carbon::now()
                ],
            ];
            DB::table('t_stok')->insert($data);
        }
        ```
        ![result t_stok](report_asset/js3/3.7.png)
    * t_penjualan
        ```php  
        public function run(): void
        {
            $data = [];
            $userIds = [1, 2, 3];
            $pembelis = ['Doni', 'Wahyu', 'Kurniawan', 'Wayak', 'Yan', 'Cha', 'Putri', 'Nad', 'Daffa', 'Ihza'];
            $penjualanKodes = ['PJL001', 'PJL002', 'PJL003', 'PJL004', 'PJL005', 'PJL006', 'PJL007', 'PJL008', 'PJL009', 'PJL010'];
            $penjualanTanggal = Carbon::now();

            foreach ($userIds as $index => $userId) {
                $data[] = [
                    'user_id' => $userId,
                    'pembeli' => $pembelis[$index],
                    'penjualan_kode' => $penjualanKodes[$index],
                    'penjualan_tanggal' => $penjualanTanggal
                ];
            }

            DB::table('t_penjualan')->insert($data);
        }
        ```
        ![result t_penjualan](report_asset/js3/3.8.png)
    * t_penjualan_detail
        ```php
        public function run(): void
        {
            $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
            $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

            $data = [];
            $count = 0;

            for ($i = 0; $i < 2; $i++) {
                foreach ($penjualanIds as $penjualanId) {
                    $randomBarangIds = array_rand($barangIds, 3);

                    foreach ($randomBarangIds as $randomBarangId) {
                        $barangId = $barangIds[$randomBarangId];
                        $hargaJual = DB::table('m_barang')->where('barang_id', $barangId)->value('harga_jual');
                        $jumlah = rand(1, 10);

                        $data[] = [
                            'barang_id' => $barangId,
                            'penjualan_id' => $penjualanId,
                            'harga' => $hargaJual * $jumlah,
                            'jumlah' => $jumlah,
                        ];

                        $count++;
                        if ($count >= 30) {
                            break 3;
                        }
                    }
                }
            }

            DB::table('t_penjualan_detail')->insert($data);
        }
        ```
        ![result t_penjualan_detail](report_asset/js3/3.9.png)
## D. DB FACADE
### Praktikum 4
1. create LevelController
    ```
    php artisan make:controller LevelController
    ```
2. route modification
    ```php
    Route::get('/level', [LevelController::class, 'index']);
    ```
3. insert data via DB Facade
    ```php
    DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
    return 'Insert data baru berhasil';
    ```
    ![insert](report_asset/js3/4.1.png)\
    ![insert](report_asset/js3/4.2.png)
4. update data via DB Facade
    ```php
    $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);;
    return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';
    ```
    ![update](report_asset/js3/4.3.png)\
    ![update](report_asset/js3/4.4.png)
5. Delete data via DB Facade
    ```php
    $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
    return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';
    ```
    ![delete](report_asset/js3/4.5.png)\
    ![delete](report_asset/js3/4.6.png)
6. Select data via DB Facade
    ```php
    $data = DB::select('select * from m_level');
    return view('level', ['data' => $data]);
    ```
    ```html
    <!DOCTYPE html>
    <head>
        <title>Data Level Pengguna</title>
    </head>
    <body>
        <h1>Data Level Pengguna</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>TD</th>
                <th>Kode Level</th>
                <th>Nama Level</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->level_id}}</td>
                <td>{{ $d->level_kode}}</td>
                <td>{{ $d->level_nama}}</td>
            </tr>
            @endforeach
        </table>
    </body>
    </html>
    ```
    ![select](report_asset/js3/4.7.png)
## E. QUERY BUILDER
### Praktikum 5
1. create KategoriController
    ```
    php artisan make:controller KategoriController
    ```
2. Insert data via query builder
    ```php
    $data = [
        'kategori_kode' => 'SNK',
        'kategori_nama' => 'Snack/Makanan Ringan',
        'created_at' => now(),
    ];
    DB::table('m_kategori')->insert($data);
    return 'Insert data baru berhasil';
    ```
    ![insert QB](report_asset/js3/5.1.png)
    ![insert QB](report_asset/js3/5.2.png)
3. Update data via query builder
    ```php
    $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';   
    ```
    ![update QB](report_asset/js3/5.3.png)
    ![update QB](report_asset/js3/5.4.png)
3. Delete data via query builder
    ```php
    $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
    return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';
    ```
    ![delete QB](report_asset/js3/5.5.png)
    ![delete QB](report_asset/js3/5.6.png)
4. Read data via query builder
    ```php
    $data = DB::table('m_kategori')->get();
    return view('kategori', ['data' => $data]);
    ```
    ![read QB](report_asset/js3/5.7.png)
## F. ELOQUENT ORM
### Praktikum 6
1. create model
    ```
    php artisan make:model UserModel
    ```
2. UserModel modification
    ```php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class UserModel extends Model
    {
        use HasFactory;

        protected $table = 'm_user';
        protected $primaryKey = 'user_id';
    }
    ```
3. route modification
    ```php
    Route::get('/user', [UserController::class, 'index']);  
    ```
4. create UserController
    ```
    php artisan make:controller UserController
    ```
5. UserController modification
    ```php
    namespace App\Http\Controllers;

    use App\Models\UserModel;
    use Illuminate\Http\Request;

    class UserController extends Controller
    {
        public function index()
        {
            $user = UserModel::all();
            return view('user', ['data' => $user]);
        }
    }

    ```
6. user view
    ```html
    <head>
        <title>Data User</title>
    </head>
    <body>
        <h1>Data User</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->user_id}}</td>
                <td>{{ $d->username}}</td>
                <td>{{ $d->nama}}</td>
                <td>{{ $d->level_id}}</td>
            </tr>
            @endforeach
        </table>
    </body>
    </html>
    ```
    ![result 6.1](report_asset/js3/6.1.png)
7. UserController modification (again)
    ```php
    namespace App\Http\Controllers;

    use App\Models\UserModel;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class UserController extends Controller
    {
        public function index()
        {
            $data = [
                'username' => 'customer-1',
                'nama' => 'Pelanggan',
                'password' => Hash::make('12345'),
                'level_id' => 4
            ];
            UserModel::insert($data);

            $user = UserModel::all();
            return view('user', ['data' => $user]);
        }
    }
    ```
    ![result 6.2](report_asset/js3/6.2.png)
8. UserController modification (again)
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $data = ['nama' => 'Pelanggan Pertama'];
            UserModel::where('username', 'customer 1')->update($data);

            $user = UserModel::all();
            return view('user', ['data' => $user]);
        }
    }
    ```
    ![result 6.2](report_asset/js3/6.3.png)
## G. PENUTUP
1. Pada Praktikum 1 - Tahap 5, apakah fungsi dari APP_KEY pada file setting .env Laravel? 
    > APP_KEY pada file setting .env Laravel adalah kunci enkripsi yang digunakan untuk mengamankan data sensitif seperti sesi pengguna dan password.
2. Pada Praktikum 1, bagaimana kita men-generate nilai untuk APP_KEY? 
    > Dengan perintah `php artisan key:generate` di terminal
3. Pada Praktikum 2.1 - Tahap 1, secara default Laravel memiliki berapa file migrasi? dan untuk apa saja file migrasi tersebut? 
    > Terdapat dua file migrasi, create_users_table.php dan create_password_resets_table.php. File-file migrasi ini digunakan untuk mengatur struktur database aplikasi Laravel, memungkinkan developer untuk mengelola dan memperbarui struktur database dengan mudah menggunakan Migrations.
4. Secara default, file migrasi terdapat kode `$table->timestamps();`, apa tujuan/output dari fungsi tersebut? 
    > Fungsi `$table->timestamps();` dalam file migrasi Laravel secara default akan menambahkan dua kolom ke tabel yang sedang dibuat, yaitu `created_at` dan `updated_at`. Kolom `created_at` akan berisi tanggal dan waktu saat baris data pertama kali dimasukkan ke dalam tabel, sementara kolom `updated_at` akan berisi tanggal dan waktu saat baris data terakhir kali diperbarui.
5. Pada File Migrasi, terdapat fungsi `$table->id()`; Tipe data apa yang dihasilkan dari fungsi tersebut? 
    > Fungsi `$table->id()` dalam file migrasi Laravel akan menghasilkan tipe data kolom yang disebut `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`. Ini adalah tipe data kolom yang  digunakan untuk membuat kolom id unik dengan auto-increment yang digunakan sebagai primary key dalam sebuah tabel.
6. Apa bedanya hasil migrasi pada table m_level, antara menggunakan `$table->id()`; dengan menggunakan `$table->id('level_id');` ? 
    > Perbedaannya terdapat pada nama kolom, jika menggunakan `$table->id();` maka akan membuat kolom dengan nama id sedangkan jika menggunakan `$table->id('level_id');` akan membuat kolom dengan nama level_id
7. Pada migration, Fungsi `->unique()` digunakan untuk apa? 
    > Fungsi `->unique` digunakan agar suatu kolom memiliki nilai yang unik, dengan tujuan agar tidak ada dua baris yang redudansi pada kolom tersebut.
8. Pada  Praktikum  2.2  -  Tahap  2,  kenapa  kolom  level_id pada  tabel  m_user menggunakan `$tabel->unsignedBigInteger('level_id')`, sedangkan kolom level_id pada tabel m_level menggunakan `$tabel->id('level_id')` ? 
    > Karena level_id pada tabel m_user merupakan sebuah FOREIGN KEY dari tabel m_level, sedangkan pada tabel m_level menggunakan id karena kolom level_id merupakan PRIMARY KEY dari tabel m_level
9. Pada Praktikum 3 - Tahap 6, apa tujuan dari Class Hash? dan apa maksud dari kode program `Hash::make('1234');`? 
    > Class Hash digunakan untuk mengenkripsi data, pada contoh praktikum 3, sebuah password perlu dienkripsi agar tidak dapat diakses dengan mudah oleh sembarang orang. kode `Hash::make('1234')`; digunakan untuk menghasilkan versi hashed dari '1234'
10. Pada Praktikum 4 - Tahap 3/5/7, pada query  builder terdapat tanda tanya (?), apa kegunaan dari tanda tanya (?) tersebut? 
    > Digunakan sebagai placeholder nilai yang akan disimpan pada query
11. Pada  Praktikum  6  -  Tahap  3,  apa  tujuan  penulisan  kode  protected  `$table  = ‘m_user’;` dan `protected $primaryKey = ‘user_id’;` ?  
    > kode tersebut digunakan untuk mendeklarasi nama tabel dan kolom PRIMARY KEY yang akan digunakan pada model tersebut. Memakai modifier protected agar variabel tersebut hanya dapat diakses dari dalam class itu sendiri dan class turunannya.  `$primaryKey = ‘user_id’;` digunakan agar model tahu bahwa kolom utamanya adalah user_id.
12. Menurut kalian, lebih mudah menggunakan mana dalam melakukan operasi CRUD ke database (DB Façade / Query Builder / Eloquent ORM) ? jelaskan 
    > Menurut saya lebih mudah menggunakan Eloquent ORM karena pendekatannya yang abstrak dan berbasis objek dalam interaksi dengan database, memungkinkan penggunaan model dan relasi antar model. Dibandingkan dengan DB Facade atau Query Builder, Eloquent ORM lebih mudah digunakan karena menyediakan sintaks yang lebih mirip dengan bahasa pemrograman. 

<br><hr>

<div align="center">

# JOBSHEET 4 <br>MODEL DAN ELOQUENT ORM

</div>

## A. PROPERTI `$fillable` DAN `$guarded`
### Praktikum 1
1. UserModel.php modification 
    ```php
    class UserModel extends Model
    {
        use HasFactory;

        protected $table = 'm_user';
        protected $primaryKey = 'user_id';
        protected $fillable = ['level_id', 'username', 'nama', 'password'];
    }
    ```
2. UserController.php modification 
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $data = [
                'level_id' => 2,
                'username' => 'manager_dua',
                'nama' => 'Manager 2',
                'password' => Hash::make('12345'),
            ];
            UserModel::create($data);

            $user = UserModel::all();
            return view('user', ['data' => $user]);
        }
    }
    ```
    result\
    ![result create with match fillable and data](report_asset/js4/1.1.png)
3. `$fillable` UserModel.php modification 
    ```php
    protected $fillable = ['level_id', 'username', 'nama'];
    ```
4. `$data` array UserController.php modification
    ```php
    $data = [
        'level_id' => 2,
        'username' => 'manager_tiga',
        'nama' => 'Manager 3',
        'password' => Hash::make('12345'),
    ];
    ```
    result\
    ![result with mismatch fillable and data](report_asset/js4/1.2.png)\
    error karena bagian fillable tidak memiliki atribut password, namun pada controller modifikasi tersebut memiliki atribut password yang ingin di create.
## B. RETRIEVING SINGLE MODELS
### Praktikum 2.1
1. UserController.php modification
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $user = UserModel::find(1);
            return view('user', ['data' => $user]);
        }
    }
    ```
2. user.blade.php modification
    ```html
    <body>
        <h1>Data User</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data->user_id}}</td>
                <td>{{ $data->username}}</td>
                <td>{{ $data->nama}}</td>
                <td>{{ $data->level_id}}</td>
            </tr>
        </table>
    </body>
    ```
    result\
    ![result 2.1.1](report_asset/js4/2.1.1.png)
3. `$user` on UserController.php modification
    ```php
    $user = UserModel::where('level_id', 1)->first();
    ```
    result\
    ![result 2.1.2](report_asset/js4/2.1.1.png)
4. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstWhere('level_id', 1);
    ```
    result\
    ![result 2.1.3](report_asset/js4/2.1.1.png)
5. `$user` on UserController.php modification
    ```php
    $user = UserModel::findOr(1, ['username', 'nama'], function() {
        abort(404);
    });
    ```
    result\
    ![result 2.1.4](report_asset/js4/2.1.2.png)
6. `$user` on UserController.php modification
    ```php
    $user = UserModel::findOr(20, ['username', 'nama'], function() {
        abort(404);
    });
    ```
    result\
    ![result 2.1.5](report_asset/js4/2.1.3.png)
### Praktikum 2.2
1. `$user` on UserController.php modification
    ```php
    $user = UserModel::findOrFail(1);
    ```
    result\
    ![result 2.2.1](report_asset/js4/2.2.1.png)
2. `$user` on UserController.php modification
    ```php
    $user = UserModel::where('username', 'manager9')->firstOrFail();
    ```
    result\
    ![result 2.2.1](report_asset/js4/2.2.2.png)
### Praktikum 2.3
1. `$user` on UserController.php modification
    ```php
    $user = UserModel::where('level_id', 2)->count();
    dd($user);
    ```
    result\
    ![result 2.3.1](report_asset/js4/2.3.1.png)
2. `$user` on UserController.php modification
    ```php
    $user = UserModel::where('level_id', 2)->count();
    ```
    `user.blade.php` modification
    ```php
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Jumlah Pengguna</th>
        </tr>
        <tr>
            <td>{{ $data }}</td>
        </tr>
    </table>
    ```
    result\
    ![result 2.3.2](report_asset/js4/2.3.2.png)
### Praktikum 2.4
1. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstOrCreate(
        [
            'username' => 'manager',
            'nama' => 'Manager',
        ]
    );
    ```
2. `user.blade.php` view modification
    ```html
    <body>
        <h1>Data User</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data->user_id}}</td>
                <td>{{ $data->username}}</td>
                <td>{{ $data->nama}}</td>
                <td>{{ $data->level_id}}</td>
            </tr>
        </table>
    </body>
    ```
    result\
    ![result 2.4.1](report_asset/js4/2.4.1.png)
3. edit `$fillable`
    ```php
    protected $fillable = ['level_id', 'username', 'nama', 'password'];
    ```
4. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstOrCreate(
        [
            'username' => 'manager22',
            'nama' => 'Manager Dua Duadua',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]
    );
    ```
    result\
    ![result 2.4.2](report_asset/js4/2.4.2.png)\
    ![result 2.4.3](report_asset/js4/2.4.3.png)
5. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstOrNew(
        [
            'username' => 'manager',
            'nama' => 'Manager',
        ],
    );
    ```
    result\
    ![result 2.4.4](report_asset/js4/2.4.4.png)
6. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstOrNew(
        [
            'username' => 'manager33',
            'nama' => 'Manager Tiga Tiga',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ],
    );
    ```
    result\
    ![result 2.4.5](report_asset/js4/2.4.5.png)\
    ![result 2.4.6](report_asset/js4/2.4.6.png)
7. `$user` on UserController.php modification
    ```php
    $user = UserModel::firstOrNew(
        [
            'username' => 'manager33',
            'nama' => 'Manager Tiga Tiga',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ],
    );
    $user->save();
    ```
    result\
    ![result 2.4.7](report_asset/js4/2.4.7.png)\
    ![result 2.4.8](report_asset/js4/2.4.8.png)
### Praktikum 2.5
1. `UserController.php` modification
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $user = UserModel::firstOrNew([
                    'username' => 'manager55',
                    'nama' => 'Manager55',
                    'password' => Hash::make('12345'),
                    'level_id' => 2
            ]);

            $user->username = 'manager55';

            $user->isDirty(); //true
            $user->isDirty('username'); //false
            $user->isDirty('nama'); //true
            $user->isDirty(['nama', 'username']); //true
            
            $user->isClean(); //false
            $user->isClean('username'); //true
            $user->isClean('nama'); //true
            $user->isClean(['nama', 'username']); //false

            $user->save();

            $user->isDirty(); //false
            $user->isClean(); //true
            dd($user->isDirty());
        }
    }
    ```
    result\
    ![result 2.5.1](report_asset/js4/2.5.1.png)
2. `UserController.php` modification
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $user = UserModel::create([
                    'username' => 'manager11',
                    'nama' => 'Manager11',
                    'password' => Hash::make('12345'),
                    'level_id' => 2
            ]);

            $user->username = 'manager12';

            $user->save();

            $user->wasChanged(); // true
            $user->wasChanged('username'); // true
            $user->wasChanged(['username', 'level_id']); // true
            $user->wasChanged('nama'); // false
            dd($user->wasChanged(['nama', 'username'])); // true
        }
    }
    ```
    result\
    ![result 2.5.2](report_asset/js4/2.5.2.png)
### Praktikum 2.6
1. `user.blade.php`
    ```html
    <body>
        <h1>Data User</h1>
        <a href="/user/tambah">+ Tambah User</a>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
                <th>Aksi</th>
            </tr>
            @foreach($data as $d)
                <tr>
                    <td>{{ $d->user_id}}</td>
                    <td>{{ $d->username}}</td>
                    <td>{{ $d->nama}}</td>
                    <td>{{ $d->level_id}}</td>
                    <td><a href="/user/ubah/{{ $d->user_id}}">Ubah</a> | <a href="/user/hapus/{{ $d->user_id}}">Hapus</a></td>
                </tr>
            @endforeach
        </table>
    </body>
    ```
2. `UserController.php`
    ```php
    class UserController extends Controller
    {
        public function index()
        {
            $user = UserModel::all();
            return view('user', ['data' => $user]);
        }
    }
    ```
    result\
    ![result 2.6.1](report_asset/js4/2.6.1.png)
3. `user_tambah.blade.php`
    ```html
    <body>
        <h1>Form Tambah Data User</h1>
        <form action="/user/tambah_simpan" method="post">
            {{ csrf_field() }}
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username">
            <br>
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama">
            <br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password">
            <br>
            <label>Level ID</label>
            <input type="number" name="level_id" placeholder="Masukkan ID Level">
            <br><br>
            <input type="submit" class="btn btn-success" value="Simpan">
        </form>
    </body>
    ```
4. routing `tambah()`
    ```php
    Route::get('/user/tambah', [UserController::class, 'tambah']);
    ```
5. `tambah()` function on `UserController.php`
    ```php
    public function tambah()
    {
        return view('user_tambah');
    }
    ```
    result\
    ![result 2.6.2](report_asset/js4/2.6.2.png)
6. routing `tambah_simpan()`
    ```php
    Route::get('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
    ```
7. `tambah_simpan()` function on `UserController.php`
    ```php
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'id_level' => $request->id_level,
        ]);

        return redirect('/user');
    }
    ```
    result\
    ![result 2.6.3](report_asset/js4/2.6.3.png)\
    ![result 2.6.4](report_asset/js4/2.6.4.png)
8. `user_ubah.blade.php`
    ```html
    <body>
        <h1>Form Ubah Data User</h1>
        <a href="user">Kembali</a>

        <form method="post" action="user/ubah_simpan">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">
            <br>
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->username }}">
            <br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" value="{{ $data->password }}">
            <br>
            <label>Level ID</label>
            <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
            <br><br>
            <input type="submit" class="btn btn-success" value="Ubah">
        </form>
    </body>
    ```
9. routing `ubah()`
    ```php
    Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
    ```
10. `ubah()` function on `UserController.php`
    ```php
    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }
    ```
    result\
    ![result 2.6.5](report_asset/js4/2.6.5.png)
11. routing `ubah_simpan()`
    ```php
    Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
    ```
    result\
    ![result 2.6.6](report_asset/js4/2.6.6.png)\
    edit level ID into 2\
    ![result 2.6.7](report_asset/js4/2.6.7.png)\
    ![result 2.6.8](report_asset/js4/2.6.8.png)
12. routing `hapus()`
    ```php
    Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
    ```
13. `hapus()` function on `UserController.php`
    ```php
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
    ```
    result\
    ![result 2.6.9](report_asset/js4/2.6.8.png)\
    hapus Doni\
    ![result 2.6.10](report_asset/js4/2.6.9.png)
### Praktikum 2.7
1. add additional script on UserModel
    ```php
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class);
    }
    ```
2. create `LevelModel.php`
    ```php
    class LevelModel extends Model
    {
        use HasFactory;
        protected $table ='m_level';
        protected $primaryKey = 'level_id';
    }
    ```
3. `index()` function on `UserController.php`
    ```php
    public function index()
    {
        $user = UserModel::with('level')->get();
        dd($user);
    }
    ```
    result\
    ![result 2.7.1](report_asset/js4/2.7.1.png)

<br><hr>

<div align="center">

# JOBSHEET 5 <br> BLADE VIEW, WEB TEMPLATING, DATATABLES

</div>

### Praktikum 1
1. Define the project requirement
    ```
    composer require jeroennoten/laravel-adminlte
    ```
2. Install project requirement
    ```
    php artisan adminlte:install
    ```
3. Create file on views/layout/app.blade.php
    ```php
    @extends('adminlte::page') 
 
    {{-- Extend and customize the browser title --}} 
    
    @section('title') 
        {{ config('adminlte.title') }} 
        @hasSection('subtitle') | @yield('subtitle') @endif 
    @stop 
    
    @vite('resources/js/app.js') 
    
    {{-- Extend and customize the page content header --}} 
    
    @section('content_header') 
        @hasSection('content_header_title') 
            <h1 class="text-muted"> 
                @yield('content_header_title') 
    
                @hasSection('content_header_subtitle') 
                <small class="text-dark"> 
                    <i class="fas fa-xs fa-angle-right text-muted"></i> 
                    @yield('content_header_subtitle') 
                </small> 
            @endif 
        </h1> 
    @endif 
    @stop 

    {{-- Rename section content to content_body --}} 

    @section('content') 
    @yield('content_body') 
    @stop 


    {{-- Create a common footer --}} 

    @section('footer') 
    <div class="float-right"> 
        Version: {{ config('app.version', '1.0.0') }} 
    </div> 

    <strong> 
        <a href="{{ config('app.company_url', '#') }}"> 
            {{ config('app.company_name', 'My company') }} 
        </a> 
    </strong> 
    @stop 


    {{-- Add common Javascript/Jquery code --}} 



    @push('js') 
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script> 

    @endpush 

    @stack('scripts') 


    {{-- Add common CSS customizations --}} 

    @push('css') 
    <link rel="stylesheet" 
    href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" /> 
    
    <style type="text/css"> 
    
        /* {{-- You can add AdminLTE customizations here --}} z */
        /* 
        .card-header { 
            border-bottom: none; 
        } 
        .card-title { 
            font-weight: 600; 
        } 
        */ 
    
    </style> 
    
    @endpush 
    ```
4. Edit resources/views/welcome.blade.php
    ```php
    @extends('layout.app')

    {{-- Customize layout sections  --}}
    @section('subtitle', 'Welcome')
    @section('content_header_title', 'Home')
    @section('content_header_subtitle', 'Welcome')

    {{-- Content body: main page content --}}
    @section('content_body')
        <p>Welcome to this beatiful admin panel.</p>
    @stop

    {{-- Push extra CSS --}}
    @push('css')
    {{-- Add here extra stylesheets --}}
    @endpush

    {{-- Push extra JS --}}
    @push('js')
        <script> console.log("Hi, I'm using the laravel-AdminLTE package!"); </script>
    @endpush
    ```
5. Result\
   ![result 1.1](report_asset/js5/1.1.png)
### Praktikum 2
1. install laravel datatables
    ```
    composer require laravel/ui --dev
    composer require yajra/laravel-datatables:^10.0
    ```
2. install node.js\
    ![result node.js](report_asset/js5/2.1.png)
3. install laravel datatables vite and sass
    * install datatables vite
        ```
        npm i laravel-datatables-vite --save-dev
        ```
        ![result datatables](report_asset/js5/2.2.png)
    * install sass
        ```
        npm install -D sass
        ```
        ![result sass](report_asset/js5/2.3.png)
4. edit resources/js/app.js
    ```javascript
    import './bootstrap';
    import "../sass/app.scss";
    import 'laravel-datatables-vite';
    ```
5. create file resources/saas/app.scss
    ```scss
    // Font
    @import url('https://fonts.bunny.net/css?family=Nunito');

    // Bootstrap
    @import 'bootstrap/scss/bootstrap.scss';

    // Datatables
    @import 'bootstrap-icons/font/bootstrap-icons.css';
    @import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
    @import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
    @import 'datatables.net-select-bs5/css/select.bootstrap5.css';
    ```
6. npm run dev\
    ![npm run dev](report_asset/js5/2.4.png)
7. create model Kategori
    ```
    php artisan datatables:make Kategori
    ```
8. edit KategoriDataTable
    ```php
    <?php

    namespace App\DataTables;

    use App\Models\Kategori;
    use App\Models\KategoriModel;
    use Illuminate\Database\Eloquent\Builder as QueryBuilder;
    use Yajra\DataTables\EloquentDataTable;
    use Yajra\DataTables\Html\Builder as HtmlBuilder;
    use Yajra\DataTables\Html\Button;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Html\Editor\Editor;
    use Yajra\DataTables\Html\Editor\Fields;
    use Yajra\DataTables\Services\DataTable;

    class KategoriDataTable extends DataTable
    {
        /**
        * Build the DataTable class.
        *
        * @param QueryBuilder $query Results from query() method.
        */
        public function dataTable(QueryBuilder $query): EloquentDataTable
        {
            return (new EloquentDataTable($query))
                ->addColumn('action', 'kategori.action')
                ->setRowId('id');
        }

        /**
        * Get the query source of dataTable.
        */
        public function query(KategoriModel $model): QueryBuilder
        {
            return $model->newQuery();
        }

        /**
        * Optional method if you want to use the html builder.
        */
        public function html(): HtmlBuilder
        {
            return $this->builder()
                        ->setTableId('kategori-table')
                        ->columns($this->getColumns())
                        ->minifiedAjax()
                        //->dom('Bfrtip')
                        ->orderBy(1)
                        ->selectStyleSingle()
                        ->buttons([
                            Button::make('excel'),
                            Button::make('csv'),
                            Button::make('pdf'),
                            Button::make('print'),
                            Button::make('reset'),
                            Button::make('reload')
                        ]);
        }

        /**
        * Get the dataTable columns definition.
        */
        public function getColumns(): array
        {
            return [
            /* Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'), */
                Column::make('kategori_id'),
                Column::make('kategori_kode'),
                Column::make('kategori_nama'),
                Column::make('created_at'),
                Column::make('updated_at'),
            ];
        }

        /**
        * Get the filename for export.
        */
        protected function filename(): string
        {
            return 'Kategori_' . date('YmdHis');
        }
    }

    ```
9. edit model Kategori
    ```php
    class KategoriModel extends Model
    {
        use HasFactory;
        protected $table = 'm_kategori';
        protected $primaryKey = 'kategori_id';
        protected $fillable = ['kategori_kode', 'kategori_nama'];

        public function barang(): HasMany
        {
            return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
        }
    }
    ```
10. edit controller kategori
    ```php
    class KategoriController extends Controller
    {
        public function index(KategoriDataTable $dataTable)
        {
            return $dataTable->render('kategori.index');
        }

        public function create()
        {
            return view('kategori.create');
        }

        public function store(Request $request)
        {
            KategoriModel::create([
                'kategori_kode' => $request->kodeKategori,
                'kategori_nama' => $request->namaKategori
            ]);
            return redirect('/kategori');
        }
    }
    ```
11. create resources/views/kategori/index.blade.php
    ```php
    @extends('layout.app')

    {{-- Customize layout sections  --}}

    @section('subtitle', 'Kategori')
    @section('content_header_title', 'Home')
    @section('content_header_subtitle', 'Kategori')

    @section('content')
        <div class="container">
            <div class="card">
                <div class="card-header">Manage Kategori</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
    ```
12. route for kategori
    ```php
    Route::get('/kategori', [KategoriController::class, 'index']);
    ```
13. setting ViteJs/script type defaults
    ```php
    <?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Yajra\DataTables\Html\Builder;

    class AppServiceProvider extends ServiceProvider
    {
        /**
        * Register any application services.
        */
        public function register(): void
        {
            //
        }

        /**
        * Bootstrap any application services.
        */
        public function boot(): void
        {
            Builder::useVite();
        }
    }
    ```
14. datatables can be loaded\
     ![result datatables](report_asset/js5/2.5.png)
### Praktikum 3
1. Configure routing
    ```php
    Route::get('/kategori/create', [KategoriController::class, 'create']);
    Route::post('/kategori', [KategoriController::class, 'store']);
    ```
2. Add new function on KategoriController
    ```php
    class KategoriController extends Controller
    {
        public function index(KategoriDataTable $dataTable)
        {
            return $dataTable->render('kategori.index');
        }

        public function create()
        {
            return view('kategori.create');
        }

        public function store(Request $request)
        {
            KategoriModel::create([
                'kategori_kode' => $request->kodeKategori,
                'kategori_nama' => $request->namaKategori
            ]);
            return redirect('/kategori');
        }
    }
    ```
3. Create file create.blade.php
    ```php
    @extends('layout.app')
    {{-- customize layout settings --}}
    @section('subtitle', 'Kategori')
    @section('content_header_title', 'Kategori')
    @section('content_header_subtitle', 'Create')
    {{-- content body --}}
    @section('content')
        <div class="container">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Buat Kategori Baru</h3>
                </div>

                <form action="../kategori" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kodeKategori">Kode Kategori</label>
                            <input type="text" class="form-control" id="kodeKategori" name="kodeKategori" placeholder="Kode Kategori">
                        </div>
                        <div class="form-group">
                            <label for="namaKategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="namaKategori" name="namaKategori" placeholder="Nama Kategori">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    ```
4. do exception CsrfToken protection
    ```php
    namespace App\Http\Middleware;

    use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

    class VerifyCsrfToken extends Middleware
    {
        /**
        * The URIs that should be excluded from CSRF verification.
        *
        * @var array<int, string>
        */
        protected $except = [
            '/kategori'
        ];
    }
    ```
5. access kategori/create\
    ![kategori/create](report_asset/js5/3.1.png)\
    ![kategori/create](report_asset/js5/3.2.png)\
    ![kategori/create](report_asset/js5/3.3.png)

### Tugas
1. Button add
![tugas](report_asset/js5/T1.png)
2. Menu halaman kategori
![tugas](report_asset/js5/T2.png)
3. Action edit
![tugas](report_asset/js5/T3.png)
4. Action delete
![tugas](report_asset/js5/T4.png)

<div align="center">

# JOBSHEET 6 <br> Template Form, Server Validation, Client Validation, CRUD

</div>

![tugas](report_asset/js6/1.1.png)\
![tugas](report_asset/js6/1.2.png)\
![tugas](report_asset/js6/1.3.png)\
![tugas](report_asset/js6/1.4.png)


<div align="center">

# JOBSHEET 7 <br> LARAVEL STARTER CODE

</div>

<div align="center">

# UTS

</div>
