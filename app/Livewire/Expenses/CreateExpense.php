<?php

declare(strict_types=1);

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateExpense extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description = null;

    #[Validate('required|numeric|min:0.01')]
    public string $amount = '';

    #[Validate('required|in:rent,utilities,salaries,supplies,maintenance,marketing,transportation,other')]
    public string $category = 'other';

    #[Validate('required|date')]
    public string $expenseDate = '';

    #[Validate('nullable|image|max:2048')]
    public $receiptImage = null;

    /**
     * Mount component
     */
    public function mount(): void
    {
        $this->expenseDate = now()->format('Y-m-d');
        $this->showModal = true;
    }

    /**
     * Create expense
     */
    public function create(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'amount' => $this->amount,
            'category' => $this->category,
            'expense_date' => $this->expenseDate,
        ];

        // Handle receipt image upload
        if ($this->receiptImage) {
            $data['receipt_image'] = $this->receiptImage->store('expenses', 'public');
        }

        Expense::create($data);

        session()->flash('success', 'Expense added successfully!');
        $this->dispatch('expense-created');
        $this->reset(['title', 'description', 'amount', 'category', 'receiptImage']);
        $this->expenseDate = now()->format('Y-m-d');
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->dispatch('expense-created');
    }

    public function render()
    {
        return view('livewire.expenses.create-expense');
    }
}
