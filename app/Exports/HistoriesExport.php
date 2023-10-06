<?php

namespace App\Exports;

use App\Models\HistoryTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoriesExport implements FromCollection, WithCustomStartCell, WithHeadings
{
  protected $user, $month;

  public function __construct($user, $month)
  {
    $this->user = $user;
    $this->month = $month;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return HistoryTransaction::select('title', 'amount', 'payment_method', 'content', 'source', 'date', 'description')->where("user_id", $this->user)->where('status', 'paid')->where("date", "like", "{$this->month}%")->orderBy("created_at", "DESC")->get();
  }

  public function startCell(): string
  {
    return 'B2';
  }

  public function headings(): array
  {
    return ['Judul', 'Metode Pembayaran', 'Jenis', 'Sumber', 'Tanggal', 'Deskripsi'];
  }
}
