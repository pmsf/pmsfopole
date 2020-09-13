var language = document.documentElement.lang === '' ? 'en' : document.documentElement.lang
var i8lnDictionary = {}
var languageLookups = 0
var languageLookupThreshold = 3
var rawDataIsLoading = false

if (getPage !== 'overview' && getPage !== 'pokedex') {
  $.fn.DataTable.ext.pager.numbers_length = 5; // limit datatables paging buttons. Only odd numbers.
}

if (raidPage && getPage === 'raids') {
  var raidTable = $('#raidTable').DataTable({
    paging: false,
    searching: true,
    info: false,
    responsive: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>'
    }
  })
}

if (getPage === 'raid_dashboard') {
  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
    var min = parseInt($('#min-level').val(), 10)
    var max = parseInt($('#max-level').val(), 10)
    var level = parseFloat(data[4]) || 0

    if ((isNaN(min) && isNaN(max)) || (isNaN(min) && level <= max) || (min <= level && isNaN(max)) || (min <= level && level <= max)) {
      return true
    }
    return false
  })

  var raidDashboardTable = $('#raidDashboardTable').DataTable({
    paging: true,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [i8ln('Show 10 rows'), i8ln('Show 25 rows'), i8ln('Show 50 rows'), i8ln('Show 100 rows'), i8ln('Show all rows')]
    ],
    searching: true,
    info: true,
    responsive: false,
    scrollX: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: '',
      searchPlaceholder: i8ln('Search...'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>',
      info: i8ln('Showing _START_ to _END_ of _TOTAL_ entries'),
      lengthMenu: '_MENU_',
      paginate: {
        next: i8ln('Next'),
        previous: i8ln('Previous')
      }
    }
  })
}

if (rewardPage && getPage === 'rewards') {
  var rewardTable = $('#rewardTable').DataTable({
    paging: false,
    searching: true,
    info: false,
    responsive: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>'
    }
  })
}

if (shinyPage && getPage === 'shiny') {
  var shinyTable = $('#shinyTable').DataTable({
    paging: false,
    searching: true,
    info: false,
    responsive: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>'
    },
    columnDefs: [
      {
        type: 'natural',
        targets: 2
      }
    ]
  })
}

if (invasionPage && getPage === 'invasion') {
  var invasionTable = $('#invasionTable').DataTable({
    paging: false,
    searching: true,
    info: false,
    responsive: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>'
    }
  })
}

if (pokemonPage && getPage === 'pokemon') {
  var pokemonTable = $('#pokemonTable').DataTable({
    paging: true,
    searching: true,
    info: true,
    responsive: false,
    scrollX: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>',
      info: i8ln('Showing _START_ to _END_ of _TOTAL_ entries'),
      lengthMenu: i8ln('Show _MENU_ entries'),
      paginate: {
        next: i8ln('Next'),
        previous: i8ln('Previous')
      }
    }
  })
}

if (nestPage && getPage === 'nest') {
  var nestTable = $('#nestTable').DataTable({
    paging: true,
    searching: true,
    info: true,
    responsive: true,
    stateSave: true,
    stateSaveCallback: function (settings, data) {
      localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
    },
    stateLoadCallback: function (settings) {
      return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
    },
    stateDuration: 0,
    language: {
      search: i8ln('Search:'),
      emptyTable: i8ln('Loading...') + '<i class="fas fa-spinner fa-spin"></i>',
      info: i8ln('Showing _START_ to _END_ of _TOTAL_ entries'),
      lengthMenu: i8ln('Show _MENU_ entries'),
      paginate: {
        next: i8ln('Next'),
        previous: i8ln('Previous')
      }
    }
  })
}

initSettings()

if (getPage !== 'pokedex') {
  updateStats()
  if (getPage !== 'nest') {
    window.setInterval(updateStats, queryDelay * 1000)
  } else {
    window.setInterval(nestMigrationTimer, 1000)
  }
}

function loadRawData() {
  var geofence = Store.get('geofence')

  return $.ajax({
    url: 'raw_data',
    type: 'POST',
    timeout: 300000,
    data: {
      token: token,
      getPage: getPage,
      geofence: geofence
    },
    cache: false,
    dataType: 'json',
    beforeSend: function beforeSend() {
      if (rawDataIsLoading) {
        return false
      } else {
        rawDataIsLoading = true
      }
    },
    complete: function complete() {
      rawDataIsLoading = false
    }
  })
}

function processOverview(i, item) {
  $('h4.pokemon-count').html(item['pokemon_count'])
  $('h4.gym-count').html(item['gym_count'])
  $('h4.raid-count').html(item['raid_count'])
  $('h4.pokestop-count').html(item['pokestop_count'])
}

function processTeams(i, item) {
  $('h4.neutral-count').html(item['neutral_count'])
  $('h4.mystic-count').html(item['mystic_count'])
  $('h4.valor-count').html(item['valor_count'])
  $('h4.instinct-count').html(item['instinct_count'])
}

function processPokestops(i, item) {
  $('h4.quest-count').html(item['quest'])
  $('h4.rocket-count').html(item['rocket'])
  $('h4.normal-lure-count').html(item['normal_lure'])
  $('h4.glacial-lure-count').html(item['glacial_lure'])
  $('h4.mossy-lure-count').html(item['mossy_lure'])
  $('h4.magnetic-lure-count').html(item['magnetic_lure'])
}

function processSpawnpoints(i, item) {
  $('h4.spawnpoint-total').html(item['total'])
  $('h4.spawnpoint-found').html(item['found'])
  $('h4.spawnpoint-missing').html(item['missing'])
}


function processRaids(i, item) {
  if (item['id'] <= 9) {
    item['id'] = '00' + item['id']
  } else if (item['id'] <= 99) {
    item['id'] = '0' + item['id']
  }
  if (item['form'] <= 0) {
    item['form'] = '00'
  }
  var costume = ''
  if (item['costume'] > 0) {
    costume = '_' + item['costume']
  }
  var boss = ''
  if (item['id'] > 0) {
    boss = '<img src="' + pokemonIconPath + 'pokemon_icon_' + item['id'] + '_' + item['form'] + costume + '.png" class="tableIcon"><br>' + item['name']
  } else {
    boss = '<img src="' + eggIconPath + 'egg' + item['lvl'] + '.png" class="tableIcon"><br>' + item['name']
  }

  raidTable.row.add([
    item['lvl'],
    boss,
    item['count'],
    item['percentage']
  ])
}

function formatTime(timestamp) {
  var date = new Date(timestamp * 1000)
  var hours = date.getHours()
  var minutes = "0" + date.getMinutes()
  var seconds = "0" + date.getSeconds()
  var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2)

  return formattedTime
}

function processRaidDashboard(i, item) {
  var despawn = ''
  var boss = ''
  var costume = ''
  var ex = ''
  var moves = i8ln('n/a')
  var hatch = i8ln('n/a')

  var gymColors = ['#999999', '#0051CF', '#FF260E', '#FECC23'] // 'Uncontested', 'Mystic', 'Valor', 'Instinct']
  var color = gymColors[item['team']]

  if (item['raid_pokemon_id'] <= 9) {
    item['raid_pokemon_id'] = '00' + item['raid_pokemon_id']
  } else if (item['raid_pokemon_id'] <= 99) {
    item['raid_pokemon_id'] = '0' + item['raid_pokemon_id']
  }

  if (item['raid_pokemon_form'] <= 0) {
    item['raid_pokemon_form'] = '00'
  }

  if (item['raid_pokemon_costume'] > 0) {
    costume = '_' + item['raid_pokemon_costume']
  }

  if (item['ex_gym'] > 0) {
    ex = '<img src="static/images/ex.png" style="position:absolute;">'
  }


  if (item['raid_pokemon_id'] > 0) {
    boss = '<img src="' + pokemonIconPath + 'pokemon_icon_' + item['raid_pokemon_id'] + '_' + item['raid_pokemon_form'] + costume + '.png" class="tableIcon"><br>' + item['raid_pokemon_name']

    despawn = formatTime(item['raid_end'])

    moves = '<nobr>' + item['raid_pokemon_move_1'] + ' <img src="static/images/types/' + item['raid_pokemon_move_1_type'] + '.png" style="height:15px;"></nobr>' +
    '<br><br>' +
    '<nobr>' + item['raid_pokemon_move_2'] + ' <img src="static/images/types/' + item['raid_pokemon_move_2_type'] + '.png" style="height:15px;"></nobr>'
  } else {
    boss = '<img src="' + eggIconPath + 'egg' + item['raid_pokemon_level'] + '.png" class="tableIcon"><br>' + item['raid_pokemon_name']

    hatch = formatTime(item['raid_start'])

    despawn = formatTime(item['raid_end'])
  }

  var gymName = '<a href="https://maps.google.com/maps?q=' + item['lat'] + ', ' + item['lon'] + '" target="_blank" style="color:#212529;">' + ex +
  '<img src="' + item['url'] + '" style="height:80px;width:80px;border-radius:50%;border:3px solid ' + color + ';"><br>' + item['gym_name'] +
  '</a>'

  raidDashboardTable.row.add([
    gymName,
    boss,
    despawn,
    hatch,
    item['raid_pokemon_level'],
    moves
  ])
}


function processRewards(i, item) {
  if (item['quest_pokemon_id'] <= 9) {
    item['quest_pokemon_id'] = '00' + item['quest_pokemon_id']
  } else if (item['quest_pokemon_id'] <= 99) {
    item['quest_pokemon_id'] = '0' + item['quest_pokemon_id']
  }
  if (item['quest_pokemon_form'] <= 0) {
    item['quest_pokemon_form'] = '00'
  }
  var reward = ''
  var type = ''
  if (item['quest_reward_type'] === 7) {
    reward = '<img src="' + pokemonIconPath + 'pokemon_icon_' + item['quest_pokemon_id'] + '_' + item['quest_pokemon_form'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Pokémon')
  } else if (item['quest_reward_type'] === 2) {
    reward = '<img src="' + itemIconPath + 'reward_' + item['quest_item_id'] + '_' + item['quest_reward_amount'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Item')
  } else if (item['quest_reward_type'] === 12) {
      reward = '<img src="' + itemIconPath + 'reward_mega_energy_' + item['quest_energy_pokemon_id'] + '.png" class="tableIcon">' +
      '<br>' + item['name']
      type = i8ln('Mega Energy')
  } else if (item['quest_reward_type'] === 3) {
    reward = '<img src="' + itemIconPath + 'reward_stardust_' + item['quest_reward_amount'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Stardust')
  }
  rewardTable.row.add([
    type,
    reward,
    item['count'],
    item['percentage']
  ])
}

function processShiny(i, item) {
  if (item['pokemon_id'] <= 9) {
    item['pokemon_id'] = '00' + item['pokemon_id']
  } else if (item['pokemon_id'] <= 99) {
    item['pokemon_id'] = '0' + item['pokemon_id']
  }
  if (item['form'] <= 0) {
    item['form'] = '00'
  }
  var costume = ''
  if (item['costume'] > 0) {
    costume = '_' + item['costume']
  }
  var pokemon = '<img src="' + pokemonIconPath + 'pokemon_icon_' + item['pokemon_id'] + '_' + item['form'] + costume + '.png" class="tableIcon"><br>' + item['name']
  var rate = item['rate'] + '<br>(' + item['percentage'] + ')'

  shinyTable.row.add([
    pokemon,
    item['shiny_count'],
    rate,
    item['sample_size']
  ])
}

function processInvasions(i, item) {
  var grunt = '<img src="static/images/grunttype/' + item['grunt_type'] + '.png" class="tableIcon"><br>' + item['name']
  invasionTable.row.add([
    grunt,
    item['count'],
    item['percentage']
  ])
}

function processPokemon(i, item) {
  var id = ''
  if (item['pokemon_id'] <= 9) {
    id = '00' + item['pokemon_id']
  } else if (item['pokemon_id'] <= 99) {
    id = '0' + item['pokemon_id']
  } else {
    id = item['pokemon_id']
  }
  if (item['form'] <= 0) {
    item['form'] = '00'
  }
  var costume = ''
  if (item['costume'] > 0) {
    costume = '_' + item['costume']
  }
  var pokemon = '<a href="?page=pokedex#' + item['name'] + '" style="color:#212529;"><img src="' + pokemonIconPath + 'pokemon_icon_' + id + '_' + item['form'] + costume + '.png" class="tableIcon"><br>' + item['name']
  var types = item['pokemon_types']
  var typeDisplay = ''
  $.each(types, function (index, type) {
    typeDisplay += '<nobr>' + i8ln(type['type']) + ' <img src="static/images/types/' + type['type'] + '.png" style="height:13px;"></nobr><br>'
  })
  pokemonTable.row.add([
    item['pokemon_id'],
    typeDisplay,
    pokemon,
    item['count'],
    item['percentage']
  ])
}

function processNests(i, item) {
  var id = ''
  if (item['pokemon_id'] <= 9) {
    id = '00' + item['pokemon_id']
  } else if (item['pokemon_id'] <= 99) {
    id = '0' + item['pokemon_id']
  } else {
    id = item['pokemon_id']
  }
  var pokemon = '<img src="' + pokemonIconPath + 'pokemon_icon_' + id + '_00.png" class="tableIcon"><br>' + item['name']
  var nestName = '<a href="https://maps.google.com/maps?q=' + item['lat'] + ', ' + item['lon'] + '" target="_blank" style="color:#212529;">' + item['nest_name'] + '</a>'

  nestTable.row.add([
    pokemon,
    nestName,
    item['avg']
  ])
}

function initSettings() {
  if (Store.get('geofence')) {
    $('#geofence').val(Store.get('geofence'))
  }
  if (Store.get('navColor')) {
    if (Store.get('navColor') === 'dark') {
      darkMode()
    } else if (Store.get('navColor') === 'grey') {
      greyMode()
    }
  }
}

function updateStats() {
  loadRawData().done(function (result) {
    if (getPage === 'overview') {
      $.each(result.overview, processOverview)
      $.each(result.teams, processTeams)
      $.each(result.pokestops, processPokestops)
      $.each(result.spawnpoints, processSpawnpoints)
    }
    if (raidPage && getPage === 'raids') {
      raidTable.clear()
      $.each(result.raids, processRaids)
      raidTable.draw()
    }
    if (getPage === 'raid_dashboard') {
      raidDashboardTable.clear()
      $.each(result.raid_dashboard, processRaidDashboard)
      raidDashboardTable.draw(false)
    }
    if (rewardPage && getPage === 'rewards') {
      rewardTable.clear()
      $.each(result.rewards, processRewards)
      rewardTable.draw()
    }
    if (shinyPage && getPage === 'shiny') {
      shinyTable.clear()
      $.each(result.shiny, processShiny)
      shinyTable.draw()
    }
    if (invasionPage && getPage === 'invasion') {
      invasionTable.clear()
      $.each(result.invasion, processInvasions)
      invasionTable.draw()
    }
    if (pokemonPage && getPage === 'pokemon') {
      pokemonTable.clear()
      $.each(result.pokemon, processPokemon)
      pokemonTable.draw(false)
    }
    if (nestPage && getPage === 'nest') {
      $.each(result.nest, processNests)
      nestTable.draw()
    }
  })
}

function i8ln(word) {
  if ($.isEmptyObject(i8lnDictionary) && language !== 'en' && languageLookups < languageLookupThreshold) {
    $.ajax({
      url: 'static/dist/locales/' + language + '.min.json',
      dataType: 'json',
      async: false,
      success: function success(data) {
        i8lnDictionary = data
      },
      error: function error(jqXHR, status, _error) {
        console.log('Error loading i8ln dictionary: ' + _error)
        languageLookups++
      }
    })
  }
  if (word in i8lnDictionary) {
    return i8lnDictionary[word]
  } else {
    // Word doesn't exist in dictionary return it as is
    return word
  }
}


function nestMigrationTimer() {
  var migrationDate = new Date('2020-06-11T00:00:00Z')
  migrationDate = (Date.parse(migrationDate) / 1000)

  var now = new Date()
  now = (Date.parse(now) / 1000)

  var timeLeft = migrationDate - now

  while (timeLeft < 0) {
    timeLeft = timeLeft + 1209600
  }

  var days = Math.floor(timeLeft / 86400)
  var hours = Math.floor((timeLeft - (days * 86400)) / 3600)
  var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60)
  var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)))

  if (hours < '10') {
    hours = '0' + hours
  }
  if (minutes < '10') {
    minutes = '0' + minutes
  }
  if (seconds < '10') {
    seconds = '0' + seconds
  }

  $('#days').html(days + '<span>' + i8ln('Days') + '</span>')
  $('#hours').html(hours + '<span>' + i8ln('Hours') + '</span>')
  $('#minutes').html(minutes + '<span>' + i8ln('Minutes') + '</span>')
  $('#seconds').html(seconds + '<span>' + i8ln('Seconds') + '</span>')
}

function lightMode() {
  $('nav#navbar_main').removeClass('bg-dark bg-secondary')
  $('nav#navbar_main').addClass('bg-light')
  $('div.card-header-navbar').removeClass('bg-dark bg-secondary btn-dark')
}
function darkMode() {
  $('nav#navbar_main').removeClass('bg-light bg-secondary')
  $('nav#navbar_main').addClass('bg-dark')
  $('div.card-header-navbar').removeClass('bg-light bg-secondary')
  $('div.card-header-navbar').addClass('bg-dark btn-dark')
}
function greyMode() {
  $('nav#navbar_main').removeClass('bg-dark bg-light')
  $('nav#navbar_main').addClass('bg-secondary')
  $('div.card-header-navbar').removeClass('bg-dark bg-light')
  $('div.card-header-navbar').addClass('bg-secondary btn-dark')
}

(function ($) {
  $.fn.visible = function (partial) {
    var $t = $(this)
    var $w = $(window)
    var viewTop = $w.scrollTop()
    var viewBottom = viewTop + $w.height()
    var _top = $t.offset().top
    var _bottom = _top + $t.height()
    var compareTop = partial === true ? _bottom : _top
    var compareBottom = partial === true ? _top : _bottom

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop))
  }
})(jQuery)

$(function () {
  // Geofence
  $('#geofence').change(function () {
    Store.set('geofence', this.value)
    updateStats()
  })

  // Pokedex
  if (getPage === 'pokedex') {
    if (window.location.hash) {
      var hash = '#' + window.location.hash.charAt(1).toUpperCase() + window.location.hash.slice(2)
      $(hash).modal('show')
      $('html, body').animate({
        'scrollTop': $(hash + '-col').offset().top
      }, 2000)
    }

    window.onhashchange = function () {
      $('div.modal').modal('hide')
      var hash = '#' + window.location.hash.charAt(1).toUpperCase() + window.location.hash.slice(2)
      setTimeout(function () {
        $(hash).modal('show')
      }, 300)
      $('html, body').animate({
        'scrollTop': $(hash + '-col').offset().top
      })
    }

    $('#pokedex-search-input').on('keyup', function () {
      var value = $(this).val().toLowerCase()
      $('#pokedex-search-list .pokedex-col').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      })
    })
  }

  // SideNav
  $('[data-trigger]').on('click', function () {
    var offcanvasId = $(this).attr('data-trigger')
    $(offcanvasId).toggleClass('show')
    $('.screen-overlay').toggleClass('show')
  })

  $('.screen-overlay').click(function () {
    $('.offcanvas').removeClass('show')
    $('.screen-overlay').removeClass('show')
  })

  $(window).on('scroll', function () {
    if (!$('#header').visible()) {
      $('.offcanvas').removeClass('show')
      $('.screen-overlay').removeClass('show')
    }
  })

  // Nav Styling
  $('#color-button-dark').on('click', function () {
    darkMode()
    Store.set('navColor', 'dark')
  })

  $('#color-button-light').on('click', function () {
    lightMode()
    Store.set('navColor', 'light')
  })

  $('#color-button-secondary').on('click', function () {
    greyMode()
    Store.set('navColor', 'grey')
  })

  if (getPage === 'raid_dashboard') {
    $('#min-level, #max-level').keyup(function () {
      raidDashboardTable.draw()
    })
    $('#min-level, #max-level').change(function () {
      raidDashboardTable.draw()
    })

    $('a.toggle-column').on('click', function (e) {
      e.preventDefault()
      var column = raidDashboardTable.column($(this).attr('data-column'))
      column.visible(!column.visible())
    })
  }
})
