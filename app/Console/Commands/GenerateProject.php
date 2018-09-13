<?php

namespace App\Console\Commands;

use App\Models\Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'train:generate-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成已创建小组的用户与目录';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $groups = Group::all();
        foreach ($groups as $group) {
            if ($group->status) {
                continue;
            }
            $this->mkdir($group->name);
            $this->make_ftp_user($group);
            $this->make_database($group);
            $this->make_website($group);
            $group->update(['status' => true]);
        }
        system('pure-pw mkdb');
        system('/etc/init.d/pure-ftpd restart');
        system('service nginx restart');
    }

    /**
     * @param $name
     */
    public function mkdir($name)
    {
        system('mkdir /www/' . $name);
        system('chown -R web-root /www/' . $name);
    }

    /**
     * @param Group $group
     */
    public function make_ftp_user(Group $group)
    {
        system("(echo $group->ftp_password; echo $group->ftp_password)" . ' | pure-pw useradd ' . $group->name . ' -u web-root -d ' . '/www/' . $group->name);
    }

    /**
     * @param Group $group
     * @throws \Exception
     */
    public function make_database(Group $group)
    {
        $connect = mysqli_connect('localhost', env('DB_ROOT_USERNAME'), env('DB_ROOT_PASSWORD'));
        $queries = [
            "CREATE USER '$group->name'@'localhost' IDENTIFIED BY '$group->db_password';",
            "GRANT USAGE ON *.* TO '$group->name'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;",
            "CREATE DATABASE IF NOT EXISTS `$group->name`;",
            "GRANT ALL PRIVILEGES ON `$group->name`.* TO '$group->name'@'localhost';",
        ];
        foreach ($queries as $query)
        {
            if (!$connect->query($query))
            {
                throw new \Exception("数据库查询出错");
                Log::info($query);
            }
        }
    }

    /**
     * @param Group $group
     */
    public function make_website(Group $group)
    {
        system("touch /etc/nginx/sites-available/$group->name");
        $config = <<<CON
server {
    listen 80;
    listen [::]:80;
    
    root /www/$group->name;    
    index index.php index.html;    
    server_name $group->name.eeyes.xyz;
    
    location / {
        try_files \$uri \$uri/ =404;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
}
CON;
        file_put_contents("/etc/nginx/sites-available/$group->name", $config);
        system("ln -s /etc/nginx/sites-available/$group->name /etc/nginx/sites-enabled");
        return;
    }
}
