<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddLoaderRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Family;
use App\Models\Installation;
use App\Models\Loader;
use App\Models\TruckLoadBack;
use App\Models\TruckLoadDriver;
use App\Models\TruckLoadInside;
use App\Models\TruckLoadList;
use App\Models\TruckLoadMaintenance;
use App\Models\TruckLoadPassenger;
use App\Models\TruckLoadSetting;
use App\Models\TruckLoadWorkOrder;
use Exception;
use Illuminate\Http\Request;

class LoaderController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public $relations = ['truckLoadList.order.invoice', 'truckLoadList.order.family',
        'truckLoadList.truckLoadMaintenance.ckEngineOil', 'truckLoadList.truckLoadMaintenance.ckTirePressure',
        'truckLoadList.truckLoadMaintenance.ckOilLevel', 'truckLoadList.truckLoadDriver.comeAlong',
        'truckLoadList.truckLoadDriver.rollRope', 'truckLoadList.truckLoadDriver.xtraStraps',
        'truckLoadList.truckLoadDriver.flashLight', 'truckLoadList.truckLoadDriver.crowBar',
        'truckLoadList.truckLoadDriver.sledge', 'truckLoadList.truckLoadDriver.hatchet',
        'truckLoadList.truckLoadDriver.craneControl', 'truckLoadList.truckLoadDriver.blueToolBox',
        'truckLoadList.truckLoadDriver.cableLock', 'truckLoadList.truckLoadDriver.d2Sprayer',
        'truckLoadList.truckLoadPassenger.ratchetSrtapQty11', 'truckLoadList.truckLoadPassenger.redSettingCushions',
        'truckLoadList.truckLoadPassenger.whiteSettingCushions', 'truckLoadList.truckLoadPassenger.rollBluePaperTowels',
        'truckLoadList.truckLoadPassenger.blackRubberMonumentPads', 'truckLoadList.truckLoadPassenger.screwDrivers',
        'truckLoadList.truckLoadPassenger.Pliers', 'truckLoadList.truckLoadPassenger.boxKnife',
        'truckLoadList.truckLoadPassenger.Tape', 'truckLoadList.truckLoadPassenger.tubesGraySilicone',
        'truckLoadList.truckLoadPassenger.squirtBottleColemanFull', 'truckLoadList.truckLoadPassenger.scrubBush',
        'truckLoadList.truckLoadPassenger.sprayBottleWindex', 'truckLoadList.truckLoadPassenger.ftLevel2',
        'truckLoadList.truckLoadInside.blackBlankets', 'truckLoadList.truckLoadInside.rubbingPaper',
        'truckLoadList.truckLoadInside.jumperCabels', 'truckLoadList.truckLoadInside.emergencyStuff',
        'truckLoadList.truckLoadInside.fireExt', 'truckLoadList.truckLoadInside.probe',
        'truckLoadList.truckLoadInside.installCheckList', 'truckLoadList.truckLoadInside.markingPencilWax',
        'truckLoadList.truckLoadInside.grayTarp', 'truckLoadList.truckLoadInside.tireRepairKit',
        'truckLoadList.truckLoadInside.bagForDirt', 'truckLoadList.truckLoadInside.monumentTagsCards',
        'truckLoadList.truckLoadBack.settingDolly', 'truckLoadList.truckLoadBack.graniteSeal', 'truckLoadList.truckLoadBack.shovel',
        'truckLoadList.truckLoadBack.sharpShooterShovel', 'truckLoadList.truckLoadBack.hoe', 'truckLoadList.truckLoadBack.rake',
        'truckLoadList.truckLoadBack.pickAx', 'truckLoadList.truckLoadBack.ftLevel4', 'truckLoadList.truckLoadBack.manualPostHoleDigger',
        'truckLoadList.truckLoadBack.gasPostHoleAuger', 'truckLoadList.truckLoadBack.dingoRollerBar', 'truckLoadList.truckLoadBack.craneRollerBar',
        'truckLoadList.truckLoadBack.tamper', 'truckLoadList.truckLoadBack.wheelBarrow', 'truckLoadList.truckLoadBack.orangePinchBar',
        'truckLoadList.truckLoadBack.blueRoller', 'truckLoadList.truckLoadBack.twoWheelChalks', 'truckLoadList.truckLoadBack.waterBuckets',
        'truckLoadList.truckLoadBack.twoByFours', 'truckLoadList.truckLoadBack.oneByFours', 'truckLoadList.truckLoadBack.grassSeed', 'truckLoadList.truckLoadBack.bucketPeaGravel',
        'truckLoadList.truckLoadSetting.graySiliconeQty', 'truckLoadList.truckLoadSetting.brownSiliconeQty', 'truckLoadList.truckLoadSetting.caulkGunQty',
        'truckLoadList.truckLoadSetting.tapeMeasureQty', 'truckLoadList.truckLoadSetting.torpedoLevel', 'truckLoadList.truckLoadSetting.markingPaint',
        'truckLoadList.truckLoadSetting.pryBar', 'truckLoadList.truckLoadSetting.Scrapers', 'truckLoadList.truckLoadSetting.boxKnifeQty',
        'truckLoadList.truckLoadSetting.blades', 'truckLoadList.truckLoadSetting.handBroom', 'truckLoadList.truckLoadSetting.trowel',
        'truckLoadList.truckLoadSetting.maskingTape', 'truckLoadList.truckLoadSetting.scrapers1', 'truckLoadList.truckLoadSetting.screwDrivers1',
        'truckLoadList.truckLoadSetting.stringLine'];

    public function index()
    {
        $Loaders = new Loader();
        $Loaders = $Loaders->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($Loaders);
    }

    public function paginationRecord()
    {
        $loaders = new Loader();
        return response()->json($this->getDataWithPagination($loaders, 'id', $this->relations, '', '', 'desc'));
    }

    public function store(AddLoaderRequest $request)
    {
        try {
            $data = json_decode($request->data, true);
            $LoaderInstance = Loader::updateOrCreate(['id' => $data['id']], $data);
            $data['truck_load_list']['loader_id'] = $LoaderInstance->id;
            if (isset($data['install_id']) && !empty($data['install_id'])) {
                $orderID = Installation::whereId($data['install_id'])->value('order_id');
                $data['truck_load_list']['order_id'] = $orderID;
            }
            $truckLoadInstance = TruckLoadList::updateOrCreate(['id' => $data['truck_load_list']['id']], $data['truck_load_list']);
            /*if (isset($data['truck_load_list']['order'])){
                $truckLoadInstance->order->family->updateOrCreate(['id' => $data['truck_load_list']['order']['family']['id']] , $data['truck_load_list']['order']['family']);
            }*/
            //truck load maintenance
            $data['truck_load_list']['truck_load_maintenance']['truck_load_list_id'] = $truckLoadInstance->id;
            $truckLoadMaintenanceInstance = TruckLoadMaintenance::updateOrCreate(['id' => $data['truck_load_list']['truck_load_maintenance']['id']], $data['truck_load_list']['truck_load_maintenance']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_maintenance']['ck_engine_oil']['id']], $data['truck_load_list']['truck_load_maintenance']['ck_engine_oil']);
            $truckLoadMaintenanceInstance->ck_engine_oil_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_maintenance']['ck_tire_pressure']['id']], $data['truck_load_list']['truck_load_maintenance']['ck_tire_pressure']);
            $truckLoadMaintenanceInstance->ck_tire_pressure_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_maintenance']['ck_oil_level']['id']], $data['truck_load_list']['truck_load_maintenance']['ck_oil_level']);
            $truckLoadMaintenanceInstance->ck_oil_level_id = $workOrderInstance->id;

            $truckLoadMaintenanceInstance->save();

            //truck load driver
            $data['truck_load_list']['truck_load_driver']['truck_load_list_id'] = $truckLoadInstance->id;
            $truckLoadDriverInstance = TruckLoadDriver::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['id']], $data['truck_load_list']['truck_load_driver']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['come_along']['id']], $data['truck_load_list']['truck_load_driver']['come_along']);
            $truckLoadDriverInstance->come_along_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['roll_rope']['id']], $data['truck_load_list']['truck_load_driver']['roll_rope']);
            $truckLoadDriverInstance->roll_rope_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['xtra_straps']['id']], $data['truck_load_list']['truck_load_driver']['xtra_straps']);
            $truckLoadDriverInstance->xtra_straps_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['flash_light']['id']], $data['truck_load_list']['truck_load_driver']['flash_light']);
            $truckLoadDriverInstance->flash_light_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['crow_bar']['id']], $data['truck_load_list']['truck_load_driver']['crow_bar']);
            $truckLoadDriverInstance->crow_bar_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['sledge']['id']], $data['truck_load_list']['truck_load_driver']['sledge']);
            $truckLoadDriverInstance->sledge_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['hatchet']['id']], $data['truck_load_list']['truck_load_driver']['hatchet']);
            $truckLoadDriverInstance->hatchet_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['crane_control']['id']], $data['truck_load_list']['truck_load_driver']['crane_control']);
            $truckLoadDriverInstance->crane_control_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['blue_tool_box']['id']], $data['truck_load_list']['truck_load_driver']['blue_tool_box']);
            $truckLoadDriverInstance->blue_tool_box_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['cable_lock']['id']], $data['truck_load_list']['truck_load_driver']['cable_lock']);
            $truckLoadDriverInstance->cable_lock_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_driver']['d2_sprayer']['id']], $data['truck_load_list']['truck_load_driver']['d2_sprayer']);
            $truckLoadDriverInstance->d_2_sprayer_id = $workOrderInstance->id;

            $truckLoadDriverInstance->save();

            //truck load passenger
            $truckLoadPassengerInstance = TruckLoadPassenger::updateOrCreate(['id' => $data['id']], $data['truck_load_list']['truck_load_passenger']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['ratchet_srtap_qty11']['id']], $data['truck_load_list']['truck_load_passenger']['ratchet_srtap_qty11']);
            $truckLoadPassengerInstance->ratchet_srtap_qty11_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['red_setting_cushions']['id']], $data['truck_load_list']['truck_load_passenger']['red_setting_cushions']);
            $truckLoadPassengerInstance->red_setting_cushions_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['white_setting_cushions']['id']], $data['truck_load_list']['truck_load_passenger']['white_setting_cushions']);
            $truckLoadPassengerInstance->white_setting_cushions_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['roll_blue_paper_towels']['id']], $data['truck_load_list']['truck_load_passenger']['roll_blue_paper_towels']);
            $truckLoadPassengerInstance->roll_blue_paper_towels_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['black_rubber_monument_pads']['id']], $data['truck_load_list']['truck_load_passenger']['black_rubber_monument_pads']);
            $truckLoadPassengerInstance->black_rubber_monument_pads_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['screw_drivers']['id']], $data['truck_load_list']['truck_load_passenger']['screw_drivers']);
            $truckLoadPassengerInstance->screw_drivers_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['pliers']['id']], $data['truck_load_list']['truck_load_passenger']['pliers']);
            $truckLoadPassengerInstance->pliers_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['box_knife']['id']], $data['truck_load_list']['truck_load_passenger']['box_knife']);
            $truckLoadPassengerInstance->box_knife_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['tape']['id']], $data['truck_load_list']['truck_load_passenger']['tape']);
            $truckLoadPassengerInstance->tape_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['tubes_gray_silicone']['id']], $data['truck_load_list']['truck_load_passenger']['tubes_gray_silicone']);
            $truckLoadPassengerInstance->tubes_gray_silicone_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['squirt_bottle_coleman_full']['id']], $data['truck_load_list']['truck_load_passenger']['squirt_bottle_coleman_full']);
            $truckLoadPassengerInstance->squirt_bottle_coleman_full_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['scrub_bush']['id']], $data['truck_load_list']['truck_load_passenger']['scrub_bush']);
            $truckLoadPassengerInstance->scrub_bush_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['spray_bottle_windex']['id']], $data['truck_load_list']['truck_load_passenger']['spray_bottle_windex']);
            $truckLoadPassengerInstance->spray_bottle_windex_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_passenger']['ft_level2']['id']], $data['truck_load_list']['truck_load_passenger']['ft_level2']);
            $truckLoadPassengerInstance->ft_level2_id = $workOrderInstance->id;

            $truckLoadPassengerInstance->save();

            //truck load inside
            $truckLoadInsideInstance = TruckLoadInside::updateOrCreate(['id' => $data['id']], $data['truck_load_list']['truck_load_inside']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['black_blankets']['id']], $data['truck_load_list']['truck_load_inside']['black_blankets']);
            $truckLoadInsideInstance->black_blankets_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['rubbing_paper']['id']], $data['truck_load_list']['truck_load_inside']['rubbing_paper']);
            $truckLoadInsideInstance->rubbing_paper_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['jumper_cabels']['id']], $data['truck_load_list']['truck_load_inside']['jumper_cabels']);
            $truckLoadInsideInstance->jumper_cabels_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['emergency_stuff']['id']], $data['truck_load_list']['truck_load_inside']['emergency_stuff']);
            $truckLoadInsideInstance->emergency_stuff_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['fire_ext']['id']], $data['truck_load_list']['truck_load_inside']['fire_ext']);
            $truckLoadInsideInstance->fire_ext_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['probe']['id']], $data['truck_load_list']['truck_load_inside']['probe']);
            $truckLoadInsideInstance->probe_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['install_check_list']['id']], $data['truck_load_list']['truck_load_inside']['install_check_list']);
            $truckLoadInsideInstance->install_check_list_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['marking_pencil_wax']['id']], $data['truck_load_list']['truck_load_inside']['marking_pencil_wax']);
            $truckLoadInsideInstance->marking_pencil_wax_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['gray_tarp']['id']], $data['truck_load_list']['truck_load_inside']['gray_tarp']);
            $truckLoadInsideInstance->gray_tarp_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['tire_repair_kit']['id']], $data['truck_load_list']['truck_load_inside']['tire_repair_kit']);
            $truckLoadInsideInstance->tire_repair_kit_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['bag_for_dirt']['id']], $data['truck_load_list']['truck_load_inside']['bag_for_dirt']);
            $truckLoadInsideInstance->bag_for_dirt_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_inside']['monument_tags_cards']['id']], $data['truck_load_list']['truck_load_inside']['monument_tags_cards']);
            $truckLoadInsideInstance->monument_tags_cards_id = $workOrderInstance->id;

            $truckLoadInsideInstance->save();

            //truck load back
            $truckLoadBackInstance = TruckLoadBack::updateOrCreate(['id' => $data['id']], $data['truck_load_list']['truck_load_back']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['setting_dolly']['id']], $data['truck_load_list']['truck_load_back']['setting_dolly']);
            $truckLoadBackInstance->setting_dolly_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['granite_seal']['id']], $data['truck_load_list']['truck_load_back']['granite_seal']);
            $truckLoadBackInstance->granite_seal_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['shovel']['id']], $data['truck_load_list']['truck_load_back']['shovel']);
            $truckLoadBackInstance->shovel_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['sharp_shooter_shovel']['id']], $data['truck_load_list']['truck_load_back']['sharp_shooter_shovel']);
            $truckLoadBackInstance->sharp_shooter_shovel_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['hoe']['id']], $data['truck_load_list']['truck_load_back']['hoe']);
            $truckLoadBackInstance->hoe_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['rake']['id']], $data['truck_load_list']['truck_load_back']['rake']);
            $truckLoadBackInstance->rake_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['pick_ax']['id']], $data['truck_load_list']['truck_load_back']['pick_ax']);
            $truckLoadBackInstance->pick_ax_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['ft_level4']['id']], $data['truck_load_list']['truck_load_back']['ft_level4']);
            $truckLoadBackInstance->ft_level_4_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['manual_post_hole_digger']['id']], $data['truck_load_list']['truck_load_back']['manual_post_hole_digger']);
            $truckLoadBackInstance->manual_post_hole_digger_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['gas_post_hole_auger']['id']], $data['truck_load_list']['truck_load_back']['gas_post_hole_auger']);
            $truckLoadBackInstance->gas_post_hole_auger_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['dingo_roller_bar']['id']], $data['truck_load_list']['truck_load_back']['dingo_roller_bar']);
            $truckLoadBackInstance->dingo_roller_bar_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['crane_roller_bar']['id']], $data['truck_load_list']['truck_load_back']['crane_roller_bar']);
            $truckLoadBackInstance->crane_roller_bar_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['tamper']['id']], $data['truck_load_list']['truck_load_back']['tamper']);
            $truckLoadBackInstance->tamper_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['wheel_barrow']['id']], $data['truck_load_list']['truck_load_back']['wheel_barrow']);
            $truckLoadBackInstance->wheel_barrow_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['orange_pinch_bar']['id']], $data['truck_load_list']['truck_load_back']['orange_pinch_bar']);
            $truckLoadBackInstance->orange_pinch_bar_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['blue_roller']['id']], $data['truck_load_list']['truck_load_back']['blue_roller']);
            $truckLoadBackInstance->blue_roller_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['two_wheel_chalks']['id']], $data['truck_load_list']['truck_load_back']['two_wheel_chalks']);
            $truckLoadBackInstance->two_wheel_chalks_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['water_buckets']['id']], $data['truck_load_list']['truck_load_back']['water_buckets']);
            $truckLoadBackInstance->water_buckets_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['two_by_fours']['id']], $data['truck_load_list']['truck_load_back']['two_by_fours']);
            $truckLoadBackInstance->two_by_fours_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['one_by_fours']['id']], $data['truck_load_list']['truck_load_back']['one_by_fours']);
            $truckLoadBackInstance->one_by_fours_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['grass_seed']['id']], $data['truck_load_list']['truck_load_back']['grass_seed']);
            $truckLoadBackInstance->grass_seed_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_back']['bucket_pea_gravel']['id']], $data['truck_load_list']['truck_load_back']['bucket_pea_gravel']);
            $truckLoadBackInstance->bucket_pea_gravel_id = $workOrderInstance->id;

            $truckLoadBackInstance->save();

            //truck load setting
            $truckLoadSettingInstance = TruckLoadSetting::updateOrCreate(['id' => $data['id']], $data['truck_load_list']['truck_load_setting']);

            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['gray_silicone_qty']['id']], $data['truck_load_list']['truck_load_setting']['gray_silicone_qty']);
            $truckLoadSettingInstance->gray_silicone_qty_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['brown_silicone_qty']['id']], $data['truck_load_list']['truck_load_setting']['brown_silicone_qty']);
            $truckLoadSettingInstance->brown_silicone_qty_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['caulk_gun_qty']['id']], $data['truck_load_list']['truck_load_setting']['caulk_gun_qty']);
            $truckLoadSettingInstance->caulk_gun_qty_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['tape_measure_qty']['id']], $data['truck_load_list']['truck_load_setting']['tape_measure_qty']);
            $truckLoadSettingInstance->tape_measure_qty_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['torpedo_level']['id']], $data['truck_load_list']['truck_load_setting']['torpedo_level']);
            $truckLoadSettingInstance->torpedo_level_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['marking_paint']['id']], $data['truck_load_list']['truck_load_setting']['marking_paint']);
            $truckLoadSettingInstance->marking_paint_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['pry_bar']['id']], $data['truck_load_list']['truck_load_setting']['pry_bar']);
            $truckLoadSettingInstance->pry_bar_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['scrapers']['id']], $data['truck_load_list']['truck_load_setting']['scrapers']);
            $truckLoadSettingInstance->scrapers_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['box_knife_qty']['id']], $data['truck_load_list']['truck_load_setting']['box_knife_qty']);
            $truckLoadSettingInstance->box_knife_qty_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['blades']['id']], $data['truck_load_list']['truck_load_setting']['blades']);
            $truckLoadSettingInstance->blades_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['hand_broom']['id']], $data['truck_load_list']['truck_load_setting']['hand_broom']);
            $truckLoadSettingInstance->hand_broom_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['trowel']['id']], $data['truck_load_list']['truck_load_setting']['trowel']);
            $truckLoadSettingInstance->trowel_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['masking_tape']['id']], $data['truck_load_list']['truck_load_setting']['masking_tape']);
            $truckLoadSettingInstance->masking_tape_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['scrapers1']['id']], $data['truck_load_list']['truck_load_setting']['scrapers1']);
            $truckLoadSettingInstance->scrapers1_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['screw_drivers1']['id']], $data['truck_load_list']['truck_load_setting']['screw_drivers1']);
            $truckLoadSettingInstance->screw_drivers1_id = $workOrderInstance->id;
            $workOrderInstance = TruckLoadWorkOrder::updateOrCreate(['id' => $data['truck_load_list']['truck_load_setting']['string_line']['id']], $data['truck_load_list']['truck_load_setting']['string_line']);
            $truckLoadSettingInstance->string_line_id = $workOrderInstance->id;


            $truckLoadInstance->truckLoadMaintenance()->save($truckLoadMaintenanceInstance);
            $truckLoadInstance->truckLoadDriver()->save($truckLoadDriverInstance);
            $truckLoadInstance->truckLoadPassenger()->save($truckLoadPassengerInstance);
            $truckLoadInstance->truckLoadInside()->save($truckLoadInsideInstance);
            $truckLoadInstance->truckLoadBack()->save($truckLoadBackInstance);
            $truckLoadInstance->truckLoadSetting()->save($truckLoadSettingInstance);

            $LoaderInstance->truckLoadList()->save($truckLoadInstance);

            $LoaderInstance->save();
            $LoaderInstance->load($this->relations);
            return response()->json($LoaderInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Loader $Loader)
    {
        $Loader->load($this->relations);
        return response()->json($Loader);
    }

    public function destroy(Loader $Loader)
    {
        /*$Loader->truckLoadList()->truckLoadMaintenance()->delete();
        $Loader->truckLoadList()->truckLoadDriver()->delete();
        $Loader->truckLoadList()->truckLoadPassenger()->delete();
        $Loader->truckLoadList()->truckLoadInside()->delete();
        $Loader->truckLoadList()->truckLoadBack()->delete();
        $Loader->truckLoadList()->truckLoadSetting()->delete();*/
        $Loader->truckLoadList()->delete();
        return $Loader->delete();
    }

    public function getColumns()
    {
        $Loader = new Loader();
        $Loader = $Loader->getTableColumns();
        $data = [];
        $data['Loader'] = $Loader;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $Loader = new Loader();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $Loader = $this->searchQuery($Loader, $request, 'Loader');
        return response()->json($this->getDataWithPagination($Loader, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
//        return $Loader->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != null;
        });
        return $arrCount;
    }

    public function getInstallation(Installation $installation)
    {
        $orderID = $installation->order_id;
        return response()->json(Family::whereOrderId($orderID)->value('name_on_stone'));
    }

    public function getLoader(Installation $installation)
    {
        $loader = Loader::with($this->relations)->whereInstallId($installation->id)->get();
        return response()->json($loader);
    }

    public function loaderOrder()
    {
        return $this->productionOrder();
    }

    public function dropDownInfo()
    {
        $loader = Loader::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($loader);
    }

    public function getNext(Loader $loader)
    {
        return $this->nextRecord(new Loader, $this->relations, $loader->id, 'desc');
    }

    public function getPrevious(Loader $loader)
    {
        return $this->previousRecord(new Loader, $this->relations, $loader->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Loader, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Loader, $this->relations, 'asc');
    }
}
