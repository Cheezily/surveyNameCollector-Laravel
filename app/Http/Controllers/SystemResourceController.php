<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemResourceController extends Controller
{
    public function total_ram_cpu() {

        # RAM usage
        $free = shell_exec('free');
        $free = (string) trim($free);
        $arr_free = explode("\n", $free);
        $memorys = explode(" ", $arr_free[1]);
        $memorys = array_filter($memorys);
        $memorys = array_merge($memorys);
        $used_memorys = $memorys[2];
        $used_memory_in_gb = number_format($used_memorys / 1048576, 2) . ' GB';
        $memory_first = $memorys[2] / $memorys[1] * 100;
        $memory = round($memory_first) . '%';
        
        $fh = fopen('/proc/meminfo', 'r');
        $memory_count = 0;
        while ($line = fgets($fh)) {
            $piece = array();
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line,
                $piece)) {
                $memory_count = $piece[1];
                break;
            }
        }

        fclose($fh);
        $total_ram = number_format($memory_count / 1048576, 2) . ' GB';

        # cpu usage
        $cpu_loaded = sys_getloadavg();
        $load_width = $cpu_loaded[0];
        $load = $cpu_loaded[0] . '% / 100%';

        return view('ram_cpu',compact('memory','total_ram','used_memory_in_gb','load','load_width'));
    }
}
