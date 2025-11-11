<?php

namespace App\Http\Livewire\Landlord;

use App\Models\Listing;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProperty extends Component
{
    use WithFileUploads;

    public $title;

    public $category;

    public $price;

    public $status = 'vacant';

    public $county;

    public $estate;

    public $location;

    public $images = [];

    public $video_url;

    public $description;

    public $is_verified = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|in:single,double,bedsitter,one-bedroom,two-bedroom',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:vacant,Booked,occupied',
        'county' => 'required|string|max:255',
        'estate' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'images' => 'required|array|min:1|max:10',
        'images.*' => 'image|mimes:jpeg,png,png,gif,svg|max:5120', // 5MB max
        'video_url' => 'nullable|url',
        'description' => 'required|string|min:10',
        'is_verified' => 'boolean',
    ];

    protected $messages = [
        'images.*.image' => 'Each file must be an image',
        'images.*.max' => 'Each image must not exceed 5MB',
        'images.required' => 'At least one image is required',
    ];

    public function render()
    {
        return view('livewire.landlord.add-property');
    }

    public function save()
    {
        Log::info('Save method called', ['data' => $this->all()]);
        $this->validate();
        Log::info('Validation Passed');
        try {
            // Handle image uploads
            $uploadedImages = [];
            foreach ($this->images as $image) {
                $path = $image->store('listings', 'public');
                $uploadedImages[] = $path;
                Log::info('Image Stored: '.$path);
            }

            // Create the listing
            $listing = Listing::create([
                'user_id' => auth()->id(),
                'title' => $this->title,
                'category' => $this->category,
                'price' => $this->price,
                'status' => $this->status,
                'county' => $this->county,
                'estate' => $this->estate,
                'location' => $this->location,
                'images' => json_encode($uploadedImages),
                'video_url' => $this->video_url,
                'description' => $this->description,
                'is_verified' => $this->is_verified,
            ]);
            Log::info('Listing created with ID: '.$listing->id);
            // Reset form
            $this->reset();
            $this->resetValidation();

            // Show success message
            session()->flash('success', 'Property listed successfully!');
            $this->dispatchBrowserEvent('show-success', 'Property Listed Successful');

            // Emit event to refresh properties list
            $this->emit('propertyAdded');
        } catch (\Exception $e) {
            Log::error('error creating listing: '.$e->getMessage());
            session()->flash('error', 'Error creating listing: '.$e->getMessage());
            $this->dispatchBrowserEvent('show-error', 'Error Creating Listing: '.$e->getMessage());
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }
}
