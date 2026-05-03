<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Http\Resources\ModuleResource;
use App\Models\SkillCourse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        return ModuleResource::collection(SkillCourse::paginate(15));
    }

    public function store(StoreModuleRequest $request)
    {
        $module = SkillCourse::create($request->validated());
        return new ModuleResource($module);
    }

    public function show(SkillCourse $module)
    {
        return new ModuleResource($module);
    }

    public function update(UpdateModuleRequest $request, SkillCourse $module)
    {
        $module->update($request->validated());
        return new ModuleResource($module);
    }

    public function destroy(SkillCourse $module)
    {
        $module->delete();
        return response()->noContent();
    }
}
