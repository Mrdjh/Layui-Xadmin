<?php
namespace app\common\Kpl;
use think\Controller;
class Kpl extends controller
{
    //查询今日0-24点每小时复制量
    public static function todayKpl()
    {
        //0点到1点的数据
        $da1 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 00:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 01:00:00', time()))
            ->sum('num');
        //1点到2点的数据
        $da2 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 01:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 02:00:00', time()))
            ->sum('num');
        $da3 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 02:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 03:00:00', time()))
            ->sum('num');
        $da4 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 03:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 04:00:00', time()))
            ->sum('num');
        $da5 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 04:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 05:00:00', time()))
            ->sum('num');
        $da6 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 05:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 06:00:00', time()))
            ->sum('num');
        $da7 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 06:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 07:00:00', time()))
            ->sum('num');
        $da8 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 07:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 08:00:00', time()))
            ->sum('num');
        $da9 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 08:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 09:00:00', time()))
            ->sum('num');
        $da10 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 09:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 10:00:00', time()))
            ->sum('num');
        $da11 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 10:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 11:00:00', time()))
            ->sum('num');
        $da12 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 11:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 12:00:00', time()))
            ->sum('num');
        $da13 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 12:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 13:00:00', time()))
            ->sum('num');
        $da14 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 13:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 14:00:00', time()))
            ->sum('num');
        $da15 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 14:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 15:00:00', time()))
            ->sum('num');
        $da16 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 15:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 16:00:00', time()))
            ->sum('num');
        $da17 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 16:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 17:00:00', time()))
            ->sum('num');
        $da18 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 17:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 18:00:00', time()))
            ->sum('num');
        $da19 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 18:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 19:00:00', time()))
            ->sum('num');
        $da20 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 19:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 20:00:00', time()))
            ->sum('num');
        $da21 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 20:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 21:00:00', time()))
            ->sum('num');
        $da22 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 21:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 22:00:00', time()))
            ->sum('num');
        $da23 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 22:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 23:00:00', time()))
            ->sum('num');
        $da24 = db('wxcopy')
            ->where('created_at','>=',date('Y-m-d 23:00:00', time()))
            ->where('created_at','<=',date('Y-m-d 23:59:59', time()))
            ->sum('num');
        //星期用户格式
        $data = [$da1,$da2,$da3,$da4,$da5,$da6,$da7,$da8,$da9,$da10,$da11,$da12,$da13,$da14,$da15,$da16,$da17,$da18,$da19,$da20,$da21,$da22,$da23,$da24];
        $time1 = db('hour')
            ->where('time','>=',date('Y-m-d 00:00:00', time()))
            ->where('time','<=',date('Y-m-d 01:00:00', time()))
            ->field('show')->find();
        //1点到2点的数据
        $time2 = db('hour')
            ->where('time','>=',date('Y-m-d 01:00:00', time()))
            ->where('time','<=',date('Y-m-d 02:00:00', time()))
            ->field('show')->find();
        $time3 = db('hour')
            ->where('time','>=',date('Y-m-d 02:00:00', time()))
            ->where('time','<=',date('Y-m-d 03:00:00', time()))
            ->field('show')->find();
        $time4 = db('hour')
            ->where('time','>=',date('Y-m-d 03:00:00', time()))
            ->where('time','<=',date('Y-m-d 04:00:00', time()))
            ->field('show')->find();
        $time5 = db('hour')
            ->where('time','>=',date('Y-m-d 04:00:00', time()))
            ->where('time','<=',date('Y-m-d 05:00:00', time()))
            ->field('show')->find();
        $time6 = db('hour')
            ->where('time','>=',date('Y-m-d 05:00:00', time()))
            ->where('time','<=',date('Y-m-d 06:00:00', time()))->field('show')->find();
        $time7 = db('hour')
            ->where('time','>=',date('Y-m-d 06:00:00', time()))
            ->where('time','<=',date('Y-m-d 07:00:00', time()))
            ->field('show')->find();
        $time8 = db('hour')
            ->where('time','>=',date('Y-m-d 07:00:00', time()))
            ->where('time','<=',date('Y-m-d 08:00:00', time()))
            ->field('show')->find();
        $time9 = db('hour')
            ->where('time','>=',date('Y-m-d 08:00:00', time()))
            ->where('time','<=',date('Y-m-d 09:00:00', time()))
            ->field('show')->find();
        $time10 = db('hour')
            ->where('time','>=',date('Y-m-d 09:00:00', time()))
            ->where('time','<=',date('Y-m-d 10:00:00', time()))
            ->field('show')->find();
        $time11 = db('hour')
            ->where('time','>=',date('Y-m-d 10:00:00', time()))
            ->where('time','<=',date('Y-m-d 11:00:00', time()))
            ->field('show')->find();
        $time12 = db('hour')
            ->where('time','>=',date('Y-m-d 11:00:00', time()))
            ->where('time','<=',date('Y-m-d 12:00:00', time()))
            ->field('show')->find();
        $time13 = db('hour')
            ->where('time','>=',date('Y-m-d 12:00:00', time()))
            ->where('time','<=',date('Y-m-d 13:00:00', time()))
            ->field('show')->find();
        $time14 = db('hour')
            ->where('time','>=',date('Y-m-d 13:00:00', time()))
            ->where('time','<=',date('Y-m-d 14:00:00', time()))
            ->field('show')->find();
        $time15 = db('hour')
            ->where('time','>=',date('Y-m-d 14:00:00', time()))
            ->where('time','<=',date('Y-m-d 15:00:00', time()))
            ->field('show')->find();
        $time16 = db('hour')
            ->where('time','>=',date('Y-m-d 15:00:00', time()))
            ->where('time','<=',date('Y-m-d 16:00:00', time()))
            ->field('show')->find();
        $time17 = db('hour')
            ->where('time','>=',date('Y-m-d 16:00:00', time()))
            ->where('time','<=',date('Y-m-d 17:00:00', time()))
            ->field('show')->find();
        $time18 = db('hour')
            ->where('time','>=',date('Y-m-d 17:00:00', time()))
            ->where('time','<=',date('Y-m-d 18:00:00', time()))
            ->field('show')->find();
        $time19 = db('hour')
            ->where('time','>=',date('Y-m-d 18:00:00', time()))
            ->where('time','<=',date('Y-m-d 19:00:00', time()))
            ->field('show')->find();
        $time20 = db('hour')
            ->where('time','>=',date('Y-m-d 19:00:00', time()))
            ->where('time','<=',date('Y-m-d 20:00:00', time()))
            ->field('show')->find();
        $time21 = db('hour')
            ->where('time','>=',date('Y-m-d 20:00:00', time()))
            ->where('time','<=',date('Y-m-d 21:00:00', time()))
            ->field('show')->find();
        $time22 = db('hour')
            ->where('time','>=',date('Y-m-d 21:00:00', time()))
            ->where('time','<=',date('Y-m-d 22:00:00', time()))
            ->field('show')->find();
        $time23 = db('hour')
            ->where('time','>=',date('Y-m-d 22:00:00', time()))
            ->where('time','<=',date('Y-m-d 23:00:00', time()))
            ->field('show')->find();
        $time24 = db('hour')
            ->where('time','>=',date('Y-m-d 23:00:00', time()))
            ->where('time','<=',date('Y-m-d 23:59:59', time()))
            ->field('show')->find();
        $timeta = [
            $time2['show'],
            $time3['show'],
            $time4['show'],
            $time5['show'],
            $time6['show'],
            $time7['show'],
            $time8['show'],
            $time9['show'],
            $time10['show'],
            $time11['show'],
            $time12['show'],
            $time13['show'],
            $time14['show'],
            $time15['show'],
            $time16['show'],
            $time17['show'],
            $time18['show'],
            $time19['show'],
            $time20['show'],
            $time21['show'],
            $time22['show'],
            $time23['show'],
            $time24['show']
        ];
//    $zero = $this->zeros($timeta);
        $data = [
            'copy'=>$data,
            'show'=>$timeta
        ];
        return $data;
    }
//    public static function zeros($data)
//    {
//        if($data <= 0)
//        {
//            return $data = 0;
//        }
//    }
    //根据用户提供的日期进行查询
    public static function lastDay($date)
    {
        //0点到1点的数据
        $da1 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('00:00:00', time()))
            ->where('created_at','<=',$date.' '.date('01:00:00', time()))
            ->sum('num');
        //1点到2点的数据
        $da2 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('01:00:00', time()))
            ->where('created_at','<=',$date.' '.date('02:00:00', time()))
            ->sum('num');
        $da3 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('02:00:00', time()))
            ->where('created_at','<=',$date.' '.date('03:00:00', time()))
            ->sum('num');
        $da4 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('03:00:00', time()))
            ->where('created_at','<=',$date.' '.date('04:00:00', time()))
            ->sum('num');
        $da5 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('04:00:00', time()))
            ->where('created_at','<=',$date.' '.date('05:00:00', time()))
            ->sum('num');
        $da6 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('05:00:00', time()))
            ->where('created_at','<=',$date.' '.date('06:00:00', time()))
            ->sum('num');
        $da7 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('06:00:00', time()))
            ->where('created_at','<=',$date.' '.date('07:00:00', time()))
            ->sum('num');
        $da8 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('07:00:00', time()))
            ->where('created_at','<=',$date.' '.date('08:00:00', time()))
            ->sum('num');
        $da9 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('08:00:00', time()))
            ->where('created_at','<=',$date.' '.date('09:00:00', time()))
            ->sum('num');
        $da10 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('09:00:00', time()))
            ->where('created_at','<=',$date.' '.date('10:00:00', time()))
            ->sum('num');
        $da11 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('10:00:00', time()))
            ->where('created_at','<=',$date.' '.date('11:00:00', time()))
            ->sum('num');
        $da12 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('11:00:00', time()))
            ->where('created_at','<=',$date.' '.date('12:00:00', time()))
            ->sum('num');
        $da13 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('12:00:00', time()))
            ->where('created_at','<=',$date.' '.date('13:00:00', time()))
            ->sum('num');
        $da14 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('13:00:00', time()))
            ->where('created_at','<=',$date.' '.date('14:00:00', time()))
            ->sum('num');
        $da15 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('14:00:00', time()))
            ->where('created_at','<=',$date.' '.date('15:00:00', time()))
            ->sum('num');
        $da16 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('15:00:00', time()))
            ->where('created_at','<=',$date.' '.date('16:00:00', time()))
            ->sum('num');
        $da17 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('16:00:00', time()))
            ->where('created_at','<=',$date.' '.date('17:00:00', time()))
            ->sum('num');
        $da18 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('17:00:00', time()))
            ->where('created_at','<=',$date.' '.date('18:00:00', time()))
            ->sum('num');
        $da19 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('18:00:00', time()))
            ->where('created_at','<=',$date.' '.date('19:00:00', time()))
            ->sum('num');
        $da20 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('19:00:00', time()))
            ->where('created_at','<=',$date.' '.date('20:00:00', time()))
            ->sum('num');
        $da21 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('20:00:00', time()))
            ->where('created_at','<=',$date.' '.date('21:00:00', time()))
            ->sum('num');
        $da22 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('21:00:00', time()))
            ->where('created_at','<=',$date.' '.date('22:00:00', time()))
            ->sum('num');
        $da23 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('22:00:00', time()))
            ->where('created_at','<=',$date.' '.date('23:00:00', time()))
            ->sum('num');
        $da24 = db('wxcopy')
            ->where('created_at','>=',$date.' '.date('23:00:00', time()))
            ->where('created_at','<=',$date.' '.date('23:59:59', time()))
            ->sum('num');
        //以此类推

        //星期用户格式
        $data = [$da1,$da2,$da3,$da4,$da5,$da6,$da7,$da8,$da9,$da10,$da11,$da12,$da13,$da14,$da15,$da16,$da17,$da18,$da19,$da20,$da21,$da22,$da23,$da24];
        return $data;
    }

    public static function CountShow()
    {
        $da1 = db('hour')
            ->where('created_at','>=',$date.' '.date('00:00:00', time()))
            ->where('created_at','<=',$date.' '.date('01:00:00', time()));
    }
}