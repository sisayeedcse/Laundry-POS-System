<?php

declare(strict_types=1);

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditExpense extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public int $expenseId;

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

    public ?string $currentReceiptImage = null;

    /**
     * Listen for edit-expense event
     */
    #[On('edit-expense')]
    public function openModal(int $expenseId): void
    {
        $this->expenseId = $expenseId;
        $this->loadExpense();
        $this->showModal = true;
        $this->resetValidation();
    }

    /**
     * Load expense data
     */
    protected function loadExpense(): void
    {
        $expense = Expense::findOrFail($this->expenseId);
        
        $this->title = $expense->title;
        $this->description = $expense->description ?? '';
        $this->amount = (string) $expense->amount;
        $this->category = $expense->category;
        $this->expenseDate = \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d');
        $this->currentReceiptImage = $expense->receipt_image;
    }

    /**
     * Remove current receipt image
     */
    public function removeCurrentImage(): void
    {
        if ($this->currentReceiptImage && \Storage::disk('public')->exists($this->currentReceiptImage)) {
            \Storage::disk('public')->delete($this->currentReceiptImage);
        }
        $this->currentReceiptImage = null;
    }

    /**
     * Update expense
     */
    public function update(): void
    {
        $this->validate();

        $expense = Expense::findOrFail($this->expenseId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'amount' => $this->amount,
            'category' => $this->category,
            'expense_date' => $this->expenseDate,
        ];

        // Handle new receipt image upload
        if ($this->receiptImage) {
            // Delete old image if exists
            if ($expense->receipt_image && \Storage::disk('public')->exists($expense->receipt_image)) {
                \Storage::disk('public')->delete($expense->receipt_image);
            }
            $data['receipt_image'] = $this->receiptImage->store('expenses', 'public');
        } elseif (!$this->currentReceiptImage) {
            $data['receipt_image'] = null;
        }

        $expense->update($data);

        $this->closeModal();
        $this->dispatch('expense-updated');
        session()->flash('success', 'Expense updated successfully!');
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['title', 'description', 'amount', 'category', 'expenseDate', 'receiptImage', 'currentReceiptImage']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.expenses.edit-expense');
    }
}
