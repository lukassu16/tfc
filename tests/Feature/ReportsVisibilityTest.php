<?php

namespace Tests\Feature;

use App\Report;
use App\Role;
use App\Services\ReportService;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Tests\TestCase;

class ReportsVisibilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_sees_all_reports()
    {
        $this->withoutExceptionHandling();

        $admin = User::create([
            'name' => 'Łukasz',
            'email' => 'test1@test1.gmail.com',
            'password' => 'password'
        ]);

        $regularUser1 = User::create([
            'name' => 'Paweł',
            'email' => 'test@test.gmail.com',
            'password' => 'password'
        ]);

        $regularUser2 = User::create([
            'name' => 'Damian',
            'email' => 'test3@test3.gmail.com',
            'password' => 'password'
        ]);

        $role = Role::create([
            'name' => 'Admin',
        ]);

        $admin->roles()->attach($role->id, [
            'from_date' => Carbon::now(),
            'to_date' => Carbon::now()
        ]);

        Report::create([
            'title' => 'title',
            'description' => 'desc',
            'category' => 'cat',
            'author_id' => $regularUser1->id,
            'status' => 'OPEN'
        ]);

        Report::create([
            'title' => 'tytul',
            'description' => 'desc',
            'category' => 'cat',
            'author_id' => $regularUser2->id,
            'status' => 'TAKEN'
        ]);

        $this->actingAs($admin);

        $request = Request();
        $reportService = new ReportService($request);

        $reportsSeenByAdmin = $reportService->getReports();

        $this->assertEquals(Report::count(), $reportsSeenByAdmin->count());
    }

        /** @test */
        public function regular_user_sees_his_reports()
        {
            $this->withoutExceptionHandling();
    
            $role = Role::create([
                'name' => 'Admin',
            ]);

            $regularUser1 = User::create([
                'name' => 'Paweł1',
                'email' => 'test2@test.gmail.com',
                'password' => 'password'
            ]);
    
            $regularUser2 = User::create([
                'name' => 'Damian1',
                'email' => 'test33@test3.gmail.com',
                'password' => 'password'
            ]);
    
            Report::create([
                'title' => 'title',
                'description' => 'desc',
                'category' => 'cat',
                'author_id' => $regularUser1->id,
                'status' => 'OPEN'
            ]);
    
            Report::create([
                'title' => 'tytul',
                'description' => 'desc',
                'category' => 'cat',
                'author_id' => $regularUser2->id,
                'status' => 'TAKEN'
            ]);
    
            $this->actingAs($regularUser1);
    
            $request = Request();
            $reportService = new ReportService($request);
    
            $reportsSeenByRegularUSer = $reportService->getReports();
    
            $this->assertEquals(
                Report::where('author_id', $regularUser1->id)->count(),
                $reportsSeenByRegularUSer->count()
            );
        }
}
