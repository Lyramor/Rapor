<?php

namespace App\Helpers;

use App\Models\UnitKerja;

class UnitKerjaHelper
{
    public static function getUnitKerjaIds()
    {
        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        $unitKerjaIds = $datafilter->pluck('id')->toArray();
        foreach ($datafilter as $unitKerja) {
            $unitKerjaIds = array_merge($unitKerjaIds, $unitKerja->childUnit->pluck('id')->toArray());
        }
        return $unitKerjaIds;
    }

    public static function getUnitKerjaNames()
    {
        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        $unitKerjaNames = $datafilter->pluck('nama_unit')->toArray();
        foreach ($datafilter as $unitKerja) {
            $unitKerjaNames = array_merge($unitKerjaNames, $unitKerja->childUnit->pluck('nama_unit')->toArray());
        }
        return $unitKerjaNames;
    }

    public static function getUnitKerjaNamesId($id)
    {
        $selectedUnitKerjaId = $id;
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        $unitKerjaNames = $datafilter->pluck('nama_unit')->toArray();
        foreach ($datafilter as $unitKerja) {
            $unitKerjaNames = array_merge($unitKerjaNames, $unitKerja->childUnit->pluck('nama_unit')->toArray());
        }
        return $unitKerjaNames;
    }

    public static function getUnitKerja()
    {
        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        return $datafilter;
    }

    public static function getUnitKerjaParent()
    {
        $selectedUnitKerjaId = session('selected_filter');
        $datafilter = UnitKerja::with('parentUnit')->where('id', $selectedUnitKerjaId)->get();
        return $datafilter;
    }

    public static function getUnitKerjaParentId()
    {
        $selectedUnitKerjaId = session('selected_filter');

        // Mengambil unit kerja dengan relasi parentUnit
        $unitKerja = UnitKerja::with('parentUnit')->find($selectedUnitKerjaId);

        // Jika unitKerja ditemukan dan memiliki parentUnit
        if ($unitKerja && $unitKerja->parentUnit) {
            return $unitKerja->parentUnit->id;
        }

        // Jika tidak ditemukan atau tidak memiliki parentUnit
        return null;
    }

    // jika session selected role = mahasiswa maka redirect ke gate
    public static function checkRole()
    {
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('gate');
        }
    }

    // getUnitKerjaNamesV1();
    public static function getUnitKerjaNamesV1($id)
    {
        $selectedUnitKerjaId = $id;
        $datafilter = UnitKerja::with('childUnit')->where('id', $selectedUnitKerjaId)->get();
        $unitKerjaNames = $datafilter->pluck('nama_unit')->toArray();
        foreach ($datafilter as $unitKerja) {
            $unitKerjaNames = array_merge($unitKerjaNames, $unitKerja->childUnit->pluck('nama_unit')->toArray());
        }
        return $unitKerjaNames;
    }
}
