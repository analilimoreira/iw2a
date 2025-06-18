let currentId = 1;

const typeTranslations = {
  normal: "Normal",
  fire: "Fogo",
  water: "Água",
  grass: "Planta",
  electric: "Elétrico",
  ice: "Gelo",
  fighting: "Lutador",
  poison: "Venenoso",
  ground: "Terrestre",
  flying: "Voador",
  psychic: "Psíquico",
  bug: "Inseto",
  rock: "Pedra",
  ghost: "Fantasma",
  dark: "Sombrio",
  dragon: "Dragão",
  steel: "Aço",
  fairy: "Fada"
};

function searchPokemon() {
  const input = document.getElementById("search").value.toLowerCase().trim();
  if (!input) return;
  fetchPokemon(input);
}

function prevPokemon() {
  if (currentId > 1) {
    currentId--;
    fetchPokemon(currentId);
  }
}

function nextPokemon() {
  currentId++;
  fetchPokemon(currentId);
}

function fetchPokemon(identifier) {
  fetch(`https://pokeapi.co/api/v2/pokemon/${identifier}`)
    .then(res => {
      if (!res.ok) throw new Error("Pokémon não encontrado");
      return res.json();
    })
    .then(data => {
      currentId = data.id;

      document.getElementById("poke-name").textContent = data.name.toUpperCase();
      document.getElementById("poke-id").textContent = data.id;
      document.getElementById("poke-img").src = data.sprites.other["official-artwork"].front_default;

      const typesContainer = document.getElementById("poke-types");
      typesContainer.innerHTML = "";

      data.types.forEach(t => {
        const typeName = t.type.name;
        const translatedType = typeTranslations[typeName] || typeName;

        const span = document.createElement("span");
        span.classList.add("type", typeName);
        span.textContent = translatedType;

        typesContainer.appendChild(span);
      });
    })
    .catch(err => {
      alert("Pokémon não encontrado!");
    });
}

// Carrega o primeiro Pokémon (Bulbasaur)
fetchPokemon(currentId);

