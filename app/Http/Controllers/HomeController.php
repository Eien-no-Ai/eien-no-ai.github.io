<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Requests\UpdateArtworkRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\ArtworkPurchase;
use App\Models\ArtworkPurchaseDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PDF;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check if authenticated user is an admin
        if (auth()->user()->is_admin == 1) {
            return redirect()->route('admin');
        }
        return view('home');
    }

    public function listUsers(Request $request)
    {
        $searchTerm = $request->input('search');
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where(function ($query) use ($searchTerm) {
                    $query->where('users.name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('users.email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('roles.name', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->paginate(5);

        $roles = Role::all();

        $message = null;
        if ($users->isEmpty()) {
            $message = "No records found for the search term: {$searchTerm}";
        } else {
            $count = $users->total();
            $message = "Showing {$count} records for the search term: {$searchTerm}";
        }

        return view('crud.list', compact('users', 'roles', 'searchTerm', 'message'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('crud.list', compact('user', 'roles'));
    }

    public function show(User $user)
    {
    }

    public function store(StoreUserRequest $request)
    {
        $role = Role::findOrFail($request->role_id);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->is_admin = $role->is_admin;
        $user->save();

        return redirect()->route('crud.list');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $role = Role::findOrFail($request->role_id);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            if (!Hash::check($request->password, $user->password)) {
                $user->password = bcrypt($request->password);
            }
        }
        $user->role_id = $request->role_id;
        $user->is_admin = $role->is_admin;
        $user->save();

        return redirect()->route('crud.list');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('crud.list');
    }

    public function adminHome()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    public function artistsHome()
    {
        $artists = Artist::all();
        return view('artist.artists', ['artists' => $artists]);
    }

    public function storeArtist(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'bio' => 'nullable',
            'featured_artwork_image_url' => 'nullable|url',
        ]);

        $artist = new Artist();
        $artist->name = $request->input('name');
        $artist->bio = $request->input('bio');
        $artist->featured_artwork_image_url = $request->input('featured_artwork_image_url');

        $artist->save();
        return redirect()->route('artist.artists');
    }

    public function updateArtist(UpdateArtistRequest $request, Artist $artist)
    {
        $artist->name = $request->name;
        $artist->bio = $request->bio;
        $artist->featured_artwork_image_url = $request->featured_artwork_image_url;
        $artist->save();

        return redirect()->route('artist.artists');
    }

    public function artworksHome()
    {
        $artworks = DB::table('artworks')
            ->join('artists', 'artworks.artist_id', '=', 'artists.id')
            ->select('artworks.*', 'artists.name as artist_name')
            ->get();
        $artists = Artist::all();
        return view('artwork.artworks', compact('artworks', 'artists'));
    }

    public function storeArtwork(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image_url' => 'required|url',
            'artist' => 'required|exists:artists,id',
        ]);

        $artwork = new Artwork;
        $artwork->title = $validatedData['title'];
        $artwork->description = $validatedData['description'];
        $artwork->price = $validatedData['price'];
        $artwork->image_url = $validatedData['image_url'];
        $artwork->artist_id = $validatedData['artist'];
        $artwork->save();

        return redirect()->route('artwork.artworks');
    }

    public function updateArtwork(UpdateArtworkRequest $request, Artwork $artwork)
    {
        $artwork->title = $request->title;
        $artwork->description = $request->description;
        $artwork->price = $request->price;
        $artwork->image_url = $request->image_url;
        $artwork->artist_id = $request->artist_id;
        $artwork->save();

        return redirect()->route('artwork.artworks');
    }

    public function purchaseArtwork($artwork_id, Request $request)
    {
        $artwork = Artwork::findOrFail($artwork_id);
        $user = auth()->user();

        $purchase = new ArtworkPurchase;
        $purchase->artwork_id = $artwork->id;
        $purchase->artist_id = $artwork->artist_id;
        $purchase->user_id = $user->id;
        $purchase->price = $artwork->price;
        $purchase->save();

        $purchaseDetails = new ArtworkPurchaseDetail;
        $purchaseDetails->purchase_id = $purchase->id;
        $purchaseDetails->artwork_id = $artwork->id;
        $purchaseDetails->artist_id = $artwork->artist_id;
        $purchaseDetails->user_id = $user->id;
        $purchaseDetails->price = $artwork->price;
        $purchaseDetails->save();

        sleep(2);

        return redirect()->route('artwork.artworks', ['id' => $artwork_id, 'purchase' => 'success']);
    }

    public function purchaseArtworkHome()
    {
        /*$artworkPurchases = ArtworkPurchase::with(['artwork', 'artist', 'user', 'status'])
            ->orderByDesc('created_at')
            ->paginate(5);*/

        $artworkPurchases = ArtworkPurchase::with(['artwork', 'artist', 'user', 'status'])
        ->join('artwork_purchase_details', 'artwork_purchases.id', '=', 'artwork_purchase_details.purchase_id')
        ->orderByDesc('artwork_purchase_details.created_at')
        ->paginate(5);

        return view('purchase.artworkpurchases', ['artworkPurchases' => $artworkPurchases]);
    }

    public function customerPurchaseHome()
    {
        $userId = Auth::user()->id;
        $purchaseDetails = ArtworkPurchaseDetail::where('user_id', $userId)
            ->join('artworks', 'artwork_purchase_details.artwork_id', '=', 'artworks.id')
            ->join('artists', 'artworks.artist_id', '=', 'artists.id')
            ->leftJoin('statuses', 'artwork_purchase_details.status_id', '=', 'statuses.id')
            ->select(
                'artwork_purchase_details.*',
                'artworks.title as artwork_title',
                'artists.name as artist_name',
                'statuses.name as status_name'
            )
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('customer.customerpurchases', ['purchaseDetails' => $purchaseDetails]);
    }

    public function approvePurchase(ArtworkPurchase $purchase)
    {
        $purchase->status_id = 2; // 2 represents "Approved"
        $purchase->save();

        return back();
    }

    public function rejectPurchase(ArtworkPurchase $purchase)
    { 
        $purchase->delete();
        return back();
    }

    public function cancelPurchase(ArtworkPurchaseDetail $purchaseDetail, Request $request)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:255',
        ]);

        $purchaseDetail->update([
            'status_id' => 3,
            'cancellation_reason' => $request->input('cancellation_reason'),
        ]);

        $purchaseDetail->artworkPurchase()->update([
            'status_id' => 3,
        ]);

        if ($purchaseDetail) {

            $purchaseDetail->cancellation_reason = $request->input('cancellation_reason');
            $purchaseDetail->save();
            
            return redirect()->back()->with('message', 'Purchase canceled successfully.');
        } else {
            return redirect()->back()->with('error', 'Purchase not found.');
        }
    }

    public function deletePurchase(ArtworkPurchase $purchase)
    {
        $purchase->delete();
        return redirect()->back();
    }

    public function generatePDF(Request $request)
    {

        $search = $request->input('search');

        $query = Artwork::join('artists', 'artworks.artist_id', '=', 'artists.id')
        ->join('artwork_purchase_details', 'artwork_purchase_details.artwork_id', '=', 'artworks.id')
        ->join('statuses', 'artwork_purchase_details.status_id', '=', 'statuses.id')
        ->join('users', 'artwork_purchase_details.user_id', '=', 'users.id')
        ->select('artworks.*', 'artists.*', 'artwork_purchase_details.*', 'statuses.id as statid','statuses.name as statusname', 'users.*');

        if ($search) {
            $query->where('artworks.title', 'LIKE', "%$search%")
                ->orWhere('artists.name', 'LIKE', "%$search%");
        }

        $artworks = $query->get();

        $data = [
            'artists' => $artworks,
        ]; 

        $pdf = PDF::loadView('crud.report', $data)->setPaper('a3');
    
        return $pdf->download('records.pdf');

    }

    
}
