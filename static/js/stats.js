var language = document.documentElement.lang === '' ? 'en' : document.documentElement.lang
var i8lnDictionary = {}
var languageLookups = 0
var languageLookupThreshold = 3


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
    }
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
    paging: false,
    searching: true,
    info: false,
    responsive: false,
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

initSettings()
updateStats()
window.setInterval(updateStats, queryDelay * 1000)

var rawDataIsLoading = false
function loadRawData() {
  var geofence = Store.get('geofence')

  return $.ajax({
    url: 'raw_data',
    type: 'POST',
    timeout: 7500,
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
  ]).draw(false)
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
  if (item['quest_pokemon_id'] > 0) {
    reward = '<img src="' + pokemonIconPath + 'pokemon_icon_' + item['quest_pokemon_id'] + '_' + item['quest_pokemon_form'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Pokémon')
  } else if (item['quest_item_id'] > 0) {
    reward = '<img src="' + itemIconPath + 'reward_' + item['quest_item_id'] + '_' + item['quest_reward_amount'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Item')
  } else {
    reward = '<img src="' + itemIconPath + 'reward_stardust_' + item['quest_reward_amount'] + '.png" class="tableIcon">' +
    '<br>' + item['name']
    type = i8ln('Stardust')
  }
  rewardTable.row.add([
    type,
    reward,
    item['count'],
    item['percentage']
  ]).draw(false)
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
  ]).draw(false)
}

function processInvasions(i, item) {
  var grunt = '<img src="static/images/grunttype/' + item['grunt_type'] + '.png" class="tableIcon"><br>' + item['name']
  invasionTable.row.add([
    grunt,
    item['count'],
    item['percentage']
  ]).draw(false)
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
  var pokemon = '<img src="' + pokemonIconPath + 'pokemon_icon_' + id + '_' + item['form'] + costume + '.png" class="tableIcon"><br>' + item['name']
  var types = item['pokemon_types']
  var typeDisplay = ''
  $.each(types, function (index, type) {
    typeDisplay += i8ln(type['type']) + '<br>'
  })
  pokemonTable.row.add([
    item['pokemon_id'],
    typeDisplay,
    pokemon,
    item['count'],
    item['percentage']
  ]).draw(false)
}

function initSettings() {
  $('#geofence').val(Store.get('geofence'))
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
    }
    if (rewardPage && getPage === 'rewards') {
      rewardTable.clear()
      $.each(result.rewards, processRewards)
    }
    if (shinyPage && getPage === 'shiny') {
      shinyTable.clear()
      $.each(result.shiny, processShiny)
    }
    if (invasionPage && getPage === 'invasion') {
      invasionTable.clear()
      $.each(result.invasion, processInvasions)
    }
    if (pokemonPage && getPage === 'pokemon') {
      pokemonTable.clear()
      $.each(result.pokemon, processPokemon)
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

$(function () {
  $('#geofence').change(function () {
    var geofence = this.value
    Store.set('geofence', geofence)
  })
})
