<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Invisnik\LaravelSteamAuth\SteamAuth as SteamAuth;
use Invisnik\LaravelSteamAuth\SteamInfo;
use App\GameAPIs\SteamUser;
use App\GameAPIs\SteamAPIConnector;

/**
 * Class SteamPagesController: Controller class for handling Steam account linking.
 * Date Created: 3/17/2021
 * @author Fernando Villarreal
 * @package App\Http\Controllers
 */
class SteamPagesController extends Controller
{

    //========================= STATIC PROPERTIES =========================

    /**
     * The SteamUser object.
     * @var SteamUser
     */
    private static $steamUser;

    //========================= CLASS PROPERTIES =========================

    /**
     * SteamAuth object.
     * @var SteamAuth
     */
    protected $steamAuth;

    //========================= CONSTRUCTOR =========================

    /**
     * SteamPagesController constructor.
     * @param SteamAuth $steamAuth
     */
    public function __construct(SteamAuth $steamAuth)
    {
        $this->middleware('auth');
        $this->steamAuth = $steamAuth;
    }

    //========================= PUBLIC FUNCTIONS =========================

    /**
     * Return the 'steamlinked' page if the user Steam user is linked, or returns the
     * 'steamlogin' page if not.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function steamLogin()
    {
        if (!is_null(session('steamData'))) {
            $steamData = session('steamData');
            return view('steamlinked', $steamData);
        }
        return view('steamlogin');
    }

    /**
     * Redirects to the official Steam login site.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function steamRedirect()
    {
        return $this->steamAuth->redirect();
    }

    /**
     * Return the 'steamlinked' page along with the Steam user's information.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function steamLinked()
    {
        // If the Steam user is already linked, get their Steam ID.
        if (!is_null(session('steamData'))) {
            $steamData = session('steamData');
            return view('accounts\steamlinked', $steamData);
        }
        // If the Steam user is in the process of getting linked, get their Steam ID.
        if ($this->steamAuth->validate()) {
            // Make a request to get more data for the Steam User.
            $steamID = $this->steamAuth->steamInfo->get('steamID64');
            $steamApiKey = Config::get('steam-auth.api_key');
            $connector = new SteamAPIConnector($steamApiKey);
            $steamUser = $connector->getSteamUser($steamID);
            // Return the view along with data for the Steam user.
            $steamData = $steamUser->toDataArray();
            session(['steamData' => $steamData]);
            return view('a/steamlinked', $steamData);
        }
        // The Steam user is not linked. Return the steamLogin page.
        return $this->steamLogin();
    }

    /**
     * Get the SteamUser object from current session.
     * @return SteamUser
     */
    public static function getSteamUser() : SteamUser
    {
        $steamData = session('steamData');
        if (isset($steamData)) {
            return SteamUser::loadSteamUser($steamData);
        }
        return new SteamUser('NULL', 'NULL', []);
    }
}
