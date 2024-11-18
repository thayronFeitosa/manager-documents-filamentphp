<div class="p-4">
    @if ($fileUrl)
        @php
            $fileExtension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
            <!-- Exibir Imagem -->
            <img src="{{ asset('storage/' . basename($fileUrl)) }}" alt="Arquivo de Imagem" class="w-full h-auto max-h-96 object-contain">
        @elseif ($fileExtension === 'pdf')
            <!-- Exibir PDF -->
            <embed src="{{ asset('storage/' . basename($fileUrl)) }}" type="application/pdf" width="100%" height="600px" />
        @else
            <p>Arquivo não suportado.</p>
        @endif
    @else
        <p>Arquivo não encontrado.</p>
    @endif
</div>
