namespace Tests\Feature;

use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanExportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_old_export_files_and_database_records(): void
    {
        // 1. Arrange: Siapkan fake disk untuk testing
        Storage::fake('local');

        // Buat record export lama (dibuat 2 hari yang lalu)
        $oldExport = Export::factory()->create([
            'created_at' => now()->subDays(2),
        ]);

        // Buat record export baru (dibuat hari ini)
        $newExport = Export::factory()->create([
            'created_at' => now(),
        ]);

        // Buat file/folder simulasi di fake storage
        Storage::disk('local')->put("filament_exports/{$oldExport->id}/test_old.xlsx", 'content');
        Storage::disk('local')->put("filament_exports/{$newExport->id}/test_new.xlsx", 'content');

        // Memastikan folder awal benar-benar ada di storage
        Storage::disk('local')->assertExists("filament_exports/{$oldExport->id}/test_old.xlsx");
        Storage::disk('local')->assertExists("filament_exports/{$newExport->id}/test_new.xlsx");

        // 2. Act: Jalankan scheduler Laravel
        $this->artisan('schedule:run');

        // 3. Assert: Verifikasi Hasilnya
        // Record lama di DB & folder fisiknya di Storage HARUS HILANG
        $this->assertDatabaseMissing('exports', ['id' => $oldExport->id]);
        Storage::disk('local')->assertMissing("filament_exports/{$oldExport->id}");

        // Record baru di DB & folder fisiknya di Storage HARUS TETAP ADA
        $this->assertDatabaseHas('exports', ['id' => $newExport->id]);
        Storage::disk('local')->assertExists("filament_exports/{$newExport->id}/test_new.xlsx");
    }
}